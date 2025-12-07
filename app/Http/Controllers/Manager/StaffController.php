<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Pastikan user adalah manager.
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
     * Tampilkan daftar semua staff.
     */
    public function index(Request $request)
    {
        $this->ensureManager($request);

        $staffs = User::where('role', 'staff')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('manager.staff.index', compact('staffs'));
    }

    /**
     * Form tambah staff baru.
     */
    public function create(Request $request)
    {
        $this->ensureManager($request);

        return view('manager.staff.create');
    }

    /**
     * Simpan staff baru.
     */
    public function store(Request $request)
    {
        $this->ensureManager($request);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'staff', // fix selalu staff
        ]);

        return redirect()
            ->route('manager.staff.index')
            ->with('success', 'Staff baru berhasil ditambahkan.');
    }

    /**
     * Form edit staff.
     */
    public function edit(Request $request, string $id)
    {
        $this->ensureManager($request);

        $staff = User::where('role', 'staff')->findOrFail($id);

        return view('manager.staff.edit', compact('staff'));
    }

    /**
     * Update staff.
     */
    public function update(Request $request, string $id)
    {
        $this->ensureManager($request);

        $staff = User::where('role', 'staff')->findOrFail($id);

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $staff->id],
            'password' => ['nullable', 'min:6', 'confirmed'],
        ]);

        $staff->name  = $data['name'];
        $staff->email = $data['email'];

        if (!empty($data['password'])) {
            $staff->password = Hash::make($data['password']);
        }

        $staff->role = 'staff'; // jaga-jaga

        $staff->save();

        return redirect()
            ->route('manager.staff.index')
            ->with('success', 'Data staff berhasil diperbarui.');
    }

    /**
     * Hapus staff.
     */
    public function destroy(Request $request, string $id)
    {
        $this->ensureManager($request);

        $staff = User::where('role', 'staff')->findOrFail($id);

        // (opsional) jangan hapus diri sendiri
        $currentUser = $request->user();
        if ($currentUser && $currentUser->id === $staff->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $staff->delete();

        return redirect()
            ->route('manager.staff.index')
            ->with('success', 'Staff berhasil dihapus.');
    }
}
