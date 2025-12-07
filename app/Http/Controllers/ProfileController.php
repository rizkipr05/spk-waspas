<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil.
     */
    public function show(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        return view('profile.show', compact('user'));
    }

    /**
     * Update data akun (nama, email, dan password opsional).
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        if (!$user) {
            abort(401, 'Anda harus login.');
        }

        $data = $request->validate([
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password'              => ['nullable', 'min:6', 'confirmed'],
        ]);

        $user->name  = $data['name'];
        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Pengaturan akun berhasil diperbarui.');
    }
}
