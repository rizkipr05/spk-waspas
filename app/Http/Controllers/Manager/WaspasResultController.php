<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\WaspasHistory;
use Illuminate\Http\Request;

class WaspasResultController extends Controller
{
    /**
     * Pastikan user role = manager.
     */
    private function ensureManager(Request $request): void
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if (!$user || $user->role !== 'manager') {
            abort(403, 'Akses ditolak. Hanya manager yang boleh mengakses halaman ini.');
        }
    }

    /**
     * List semua riwayat perhitungan WASPAS dari seluruh staff.
     */
    public function index(Request $request)
    {
        $this->ensureManager($request);

        $keyword = $request->get('q');

        $histories = WaspasHistory::with(['user'])
            ->withCount('items')
            ->when($keyword, function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhereHas('user', function ($q2) use ($keyword) {
                      $q2->where('name', 'like', '%' . $keyword . '%');
                  });
            })
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('manager.waspas.index', compact('histories', 'keyword'));
    }

    /**
     * Detail satu hasil perhitungan (ranking influencer).
     */
    public function show(Request $request, string $id)
    {
        $this->ensureManager($request);

        $history = WaspasHistory::with(['user', 'items.influencer'])
            ->findOrFail($id);

        $items = $history->items()
            ->with('influencer')
            ->orderBy('rank')
            ->get();

        return view('manager.waspas.show', compact('history', 'items'));
    }
}
