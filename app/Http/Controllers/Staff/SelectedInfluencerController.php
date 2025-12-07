<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\WaspasHistoryItem;
use Illuminate\Http\Request;

class SelectedInfluencerController extends Controller
{
    private function ensureStaff(Request $request): void
    {
        $user = $request->user();

        if (!$user || $user->role !== 'staff') {
            abort(403, 'Akses ditolak');
        }
    }

    /**
     * Toggle pilihan endorsement
     */
    public function toggle(Request $request, $id)
    {
        $this->ensureStaff($request);

        $item = WaspasHistoryItem::with('history')
            ->findOrFail($id);

        if ($item->history->user_id !== $request->user()->id) {
            abort(403, 'Tidak boleh mengubah data milik staff lain.');
        }

        $item->selected = !$item->selected;
        $item->save();

        return back()->with('success', 'Status pilihan influencer berhasil diperbarui.');
    }

    /**
     * Daftar influencer yang dipilih untuk endorse
     */
    public function selectedList(Request $request)
    {
        $this->ensureStaff($request);

        $selected = WaspasHistoryItem::with(['influencer', 'history'])
            ->where('selected', true)
            ->whereHas('history', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('staff.waspas.selected', compact('selected'));
    }
}
