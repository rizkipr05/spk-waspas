<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use Illuminate\Http\Request;

class InfluencerController extends Controller
{
    /**
     * Pastikan user role = staff.
     */
    private function ensureStaff(Request $request): void
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if (!$user || $user->role !== 'staff') {
            abort(403, 'Akses ditolak. Hanya staff yang boleh mengelola data influencer.');
        }
    }

    /**
     * List influencer.
     */
    public function index(Request $request)
    {
        $this->ensureStaff($request);

        $query = Influencer::query()->orderByDesc('created_at');

        $search = $request->get('q');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('platform', 'like', '%' . $search . '%')
                    ->orWhere('niche', 'like', '%' . $search . '%');
            });
        }

        $influencers = $query->paginate(10)->withQueryString();

        return view('staff.influencers.index', compact('influencers', 'search'));
    }

    /**
     * Form tambah influencer.
     */
    public function create(Request $request)
    {
        $this->ensureStaff($request);

        return view('staff.influencers.create');
    }

    /**
     * Simpan influencer baru.
     */
    public function store(Request $request)
    {
        $this->ensureStaff($request);

        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'username'        => ['nullable', 'string', 'max:255'],
            'platform'        => ['required', 'string', 'max:100'],
            'followers'       => ['required', 'integer', 'min:0'],
            'engagement_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'niche'           => ['nullable', 'string', 'max:255'],
            'email'           => ['nullable', 'email', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'profile_link'    => ['nullable', 'url', 'max:255'],
            'notes'           => ['nullable', 'string'],
        ]);

        Influencer::create($data);

        return redirect()
            ->route('staff.influencers.index')
            ->with('success', 'Influencer baru berhasil ditambahkan.');
    }

    /**
     * Form edit influencer.
     */
    public function edit(Request $request, string $id)
    {
        $this->ensureStaff($request);

        $influencer = Influencer::findOrFail($id);

        return view('staff.influencers.edit', compact('influencer'));
    }

    /**
     * Update data influencer.
     */
    public function update(Request $request, string $id)
    {
        $this->ensureStaff($request);

        $influencer = Influencer::findOrFail($id);

        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'username'        => ['nullable', 'string', 'max:255'],
            'platform'        => ['required', 'string', 'max:100'],
            'followers'       => ['required', 'integer', 'min:0'],
            'engagement_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'niche'           => ['nullable', 'string', 'max:255'],
            'email'           => ['nullable', 'email', 'max:255'],
            'phone'           => ['nullable', 'string', 'max:50'],
            'profile_link'    => ['nullable', 'url', 'max:255'],
            'notes'           => ['nullable', 'string'],
        ]);

        $influencer->update($data);

        return redirect()
            ->route('staff.influencers.index')
            ->with('success', 'Data influencer berhasil diperbarui.');
    }

    /**
     * Hapus influencer.
     */
    public function destroy(Request $request, string $id)
    {
        $this->ensureStaff($request);

        $influencer = Influencer::findOrFail($id);
        $influencer->delete();

        return redirect()
            ->route('staff.influencers.index')
            ->with('success', 'Influencer berhasil dihapus.');
    }
}
