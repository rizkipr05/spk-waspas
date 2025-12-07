@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
@php
    $roleColor = $user->role === 'manager' ? 'primary' : 'success';
    $roleLabel = strtoupper($user->role);
    $initial   = strtoupper(mb_substr($user->name ?? 'U', 0, 1, 'UTF-8'));
@endphp

<div class="row justify-content-center">
    <div class="col-lg-10">

        {{-- Header atas --}}
        <div class="mb-4">
            <h3 class="fw-semibold mb-1">Profil & Pengaturan Akun</h3>
            <p class="text-muted mb-0">
                Kelola informasi akun yang digunakan pada sistem SPK Influencer (metode WASPAS).
            </p>
        </div>

        {{-- Alert sukses & error --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="row g-4">
            {{-- Kartu profil kiri --}}
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 bg-dark text-white position-relative">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width:64px;height:64px;background:linear-gradient(135deg,#38bdf8,#a855f7);">
                                <span class="fs-3 fw-bold text-slate-900">
                                    {{ $initial }}
                                </span>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-semibold">{{ $user->name }}</h5>
                                <span class="badge bg-{{ $roleColor }} text-uppercase"
                                      style="letter-spacing:.12em;font-size:.7rem;">
                                    {{ $roleLabel }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-4 small text-white-50">
                            <div class="d-flex align-items-center mb-1">
                                <span class="me-2">Email:</span>
                                <span class="fw-semibold text-white">{{ $user->email }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <span class="me-2">Bergabung:</span>
                                <span class="fw-semibold text-white">
                                    {{ $user->created_at?->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                        <div class="position-absolute opacity-10" style="right:-20px;bottom:-10px;font-size:4rem;">
                            ⭐
                        </div>
                    </div>

                    <div class="card-body p-3">
                        <p class="small text-muted mb-2">
                            Ringkasan
                        </p>
                        <p class="small mb-0">
                            Akun ini digunakan untuk mengelola data dan perhitungan dalam sistem SPK Influencer.
                            Jaga kerahasiaan email dan password Anda untuk keamanan sistem.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Pengaturan akun kanan --}}
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 fw-semibold">Pengaturan Akun</h6>
                            <small class="text-muted">
                                Ubah nama, email, dan password akun Anda
                            </small>
                        </div>
                        <span class="badge bg-light text-secondary">
                            ID: {{ $user->id }}
                        </span>
                    </div>

                    <div class="card-body px-4 pb-4 pt-0">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                {{-- Nama --}}
                                <div class="col-md-6">
                                    <label for="name" class="form-label small text-muted mb-1">Nama Lengkap</label>
                                    <input
                                        type="text"
                                        name="name"
                                        id="name"
                                        class="form-control form-control-sm @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label for="email" class="form-label small text-muted mb-1">Email</label>
                                    <input
                                        type="email"
                                        name="email"
                                        id="email"
                                        class="form-control form-control-sm @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password baru --}}
                                <div class="col-md-6">
                                    <label for="password" class="form-label small text-muted mb-1">
                                        Password Baru
                                        <span class="text-muted">(opsional)</span>
                                    </label>
                                    <input
                                        type="password"
                                        name="password"
                                        id="password"
                                        class="form-control form-control-sm @error('password') is-invalid @enderror"
                                        placeholder="Kosongkan jika tidak ingin mengubah"
                                    >
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Konfirmasi password --}}
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label small text-muted mb-1">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input
                                        type="password"
                                        name="password_confirmation"
                                        id="password_confirmation"
                                        class="form-control form-control-sm"
                                        placeholder="Ulangi password baru"
                                    >
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Info keamanan tambahan --}}
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body px-4 py-3">
                        <h6 class="fw-semibold mb-1">Tips Keamanan</h6>
                        <p class="small text-muted mb-2">
                            Gunakan password yang kuat dan tidak digunakan di layanan lain. Hindari membagikan akun
                            ini kepada orang lain, terutama untuk akses ke data perhitungan SPK dan hasil rekomendasi influencer.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
