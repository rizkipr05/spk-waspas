<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\WaspasHistoryItem;
use Illuminate\Http\Request;

class EndorseHistoryController extends Controller
{
    private function ensureManager(Request $request): void
    {
        $user = $request->user();
        if (!$user || $user->role !== 'manager') {
            abort(403, 'Akses ditolak. Hanya manager yang boleh melihat riwayat endorse.');
        }
    }

    /**
     * Menampilkan semua influencer yang dipilih (selected) dari semua staff.
     */
    public function index(Request $request)
    {
        $this->ensureManager($request);

        $keyword = $request->get('q');

        $selected = WaspasHistoryItem::with(['influencer', 'history.user'])
            ->where('selected', true)
            ->when($keyword, function ($q) use ($keyword) {
                $q->whereHas('influencer', function ($x) use ($keyword) {
                    $x->where('name', 'like', "%$keyword%")
                      ->orWhere('platform', 'like', "%$keyword%")
                      ->orWhere('username', 'like', "%$keyword%");
                })
                ->orWhereHas('history', function ($x) use ($keyword) {
                    $x->where('title', 'like', "%$keyword%");
                });
            })
            ->orderByDesc('updated_at')
            ->paginate(12)
            ->withQueryString();

        return view('manager.endorse.index', compact('selected', 'keyword'));
    }
}
