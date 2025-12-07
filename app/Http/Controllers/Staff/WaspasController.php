<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Criterion;
use App\Models\Influencer;
use App\Models\WaspasHistory;
use App\Models\WaspasHistoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WaspasController extends Controller
{
    /**
     * Pastikan user role = staff.
     */
    private function ensureStaff(Request $request): void
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if (!$user || $user->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya staff yang boleh melakukan perhitungan WASPAS.');
        }
    }

    /**
     * List riwayat perhitungan.
     */
    public function index(Request $request)
    {
        $this->ensureStaff($request);

        $histories = WaspasHistory::withCount('items')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('staff.waspas.index', compact('histories'));
    }

    /**
     * Form input perhitungan WASPAS.
     */
    public function create(Request $request)
    {
        $this->ensureStaff($request);

        $criteria = Criterion::where('is_active', true)
            ->orderBy('code')
            ->get();

        $influencers = Influencer::orderBy('name')->get();

        if ($criteria->isEmpty()) {
            return redirect()
                ->route('staff.criteria.index')
                ->with('success', 'Silakan buat kriteria & bobot terlebih dahulu sebelum melakukan perhitungan WASPAS.');
        }

        if ($influencers->isEmpty()) {
            return redirect()
                ->route('staff.influencers.index')
                ->with('success', 'Silakan tambahkan data influencer terlebih dahulu sebelum melakukan perhitungan WASPAS.');
        }

        return view('staff.waspas.create', compact('criteria', 'influencers'));
    }

    /**
     * Proses perhitungan WASPAS & simpan riwayat.
     */
    public function store(Request $request)
    {
        $this->ensureStaff($request);

        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'scores'      => ['required', 'array'], // scores[influencer_id][criterion_id] = value
        ]);

        $criteria = Criterion::where('is_active', true)
            ->orderBy('code')
            ->get();

        if ($criteria->isEmpty()) {
            return back()->withErrors('Kriteria aktif tidak ditemukan.')->withInput();
        }

        $scoresInput = $data['scores']; // array

        // Filter influencer yang benar-benar ada di input
        $influencerIds = array_keys($scoresInput);
        $influencers = Influencer::whereIn('id', $influencerIds)
            ->orderBy('name')
            ->get()
            ->keyBy('id');

        if ($influencers->isEmpty()) {
            return back()->withErrors('Tidak ada influencer yang dipilih.')->withInput();
        }

        // Build decision matrix & cari min/max per kriteria
        $minByCriterion = [];
        $maxByCriterion = [];
        $valuesByInfCrit = []; // [infId][critId] = value

        foreach ($criteria as $criterion) {
            $minByCriterion[$criterion->id] = null;
            $maxByCriterion[$criterion->id] = null;

            foreach ($influencerIds as $infId) {
                if (!isset($scoresInput[$infId][$criterion->id])) {
                    continue;
                }

                $val = (float) $scoresInput[$infId][$criterion->id];

                $valuesByInfCrit[$infId][$criterion->id] = $val;

                if ($minByCriterion[$criterion->id] === null || $val < $minByCriterion[$criterion->id]) {
                    $minByCriterion[$criterion->id] = $val;
                }
                if ($maxByCriterion[$criterion->id] === null || $val > $maxByCriterion[$criterion->id]) {
                    $maxByCriterion[$criterion->id] = $val;
                }
            }
        }

        // Hitung WASPAS (WSM + WPM)
        $results = []; // per influencer

        foreach ($influencerIds as $infId) {
            if (!isset($influencers[$infId])) {
                continue;
            }

            $q1 = 0.0;   // WSM
            $q2 = 1.0;   // WPM
            $normalizedByCrit = [];

            foreach ($criteria as $criterion) {
                $critId = $criterion->id;
                $weight = (float) $criterion->weight;

                if (!isset($valuesByInfCrit[$infId][$critId])) {
                    $xij = 0.0;
                } else {
                    $xij = (float) $valuesByInfCrit[$infId][$critId];
                }

                $normalized = 0.0;

                // Normalisasi
                if ($criterion->type === 'benefit') {
                    $maxVal = $maxByCriterion[$critId] ?: 1.0;
                    $normalized = $maxVal > 0 ? $xij / $maxVal : 0.0;
                } else { // cost
                    $minVal = $minByCriterion[$critId] ?: 1.0;
                    $normalized = $xij > 0 ? $minVal / $xij : 0.0;
                }

                $normalizedByCrit[$critId] = $normalized;

                // WSM
                $q1 += $weight * $normalized;

                // WPM
                if ($normalized > 0) {
                    $q2 *= pow($normalized, $weight);
                }
            }

            $qi = 0.5 * $q1 + 0.5 * $q2;

            $results[] = [
                'influencer_id' => $infId,
                'q1'            => $q1,
                'q2'            => $q2,
                'qi'            => $qi,
                'normalized'    => $normalizedByCrit,
                'values'        => $valuesByInfCrit[$infId] ?? [],
            ];
        }

        // Sort hasil berdasarkan Qi (desc)
        usort($results, function ($a, $b) {
            if ($a['qi'] === $b['qi']) {
                return 0;
            }
            return $a['qi'] < $b['qi'] ? 1 : -1;
        });

        // Simpan ke DB dalam transaksi
        $history = null;

        DB::transaction(function () use ($request, $data, $criteria, $results, &$history) {
            $history = WaspasHistory::create([
                'user_id'          => $request->user()->id,
                'title'            => $data['title'],
                'description'      => $data['description'] ?? null,
                'criteria_snapshot'=> $criteria->map(function ($c) {
                    return [
                        'id'          => $c->id,
                        'code'        => $c->code,
                        'name'        => $c->name,
                        'type'        => $c->type,
                        'weight'      => (float) $c->weight,
                        'is_active'   => $c->is_active,
                    ];
                })->values()->all(),
            ]);

            $rank = 1;
            foreach ($results as $res) {
                WaspasHistoryItem::create([
                    'waspas_history_id' => $history->id,
                    'influencer_id'     => $res['influencer_id'],
                    'final_score'       => $res['qi'],
                    'rank'              => $rank++,
                    'raw_scores'        => [
                        'q1'         => $res['q1'],
                        'q2'         => $res['q2'],
                        'normalized' => $res['normalized'],
                        'values'     => $res['values'],
                    ],
                ]);
            }
        });

        if (!$history) {
            abort(500, 'Gagal menyimpan riwayat perhitungan WASPAS.');
        }

        return redirect()
            ->route('staff.waspas.show', $history->id)
            ->with('success', 'Perhitungan WASPAS berhasil disimpan.');
    }

    /**
     * Detail hasil perhitungan (ranking).
     */
    public function show(Request $request, string $id)
    {
        $this->ensureStaff($request);

        $history = WaspasHistory::with(['items.influencer'])
            ->where('user_id', $request->user()->id)
            ->findOrFail($id);

        $items = $history->items()
            ->with('influencer')
            ->orderBy('rank')
            ->get();

        return view('staff.waspas.show', compact('history', 'items'));
    }
}
