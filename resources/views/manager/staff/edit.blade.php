@extends('layouts.app')

@section('title', 'Edit Staff')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h4 class="mb-3">Edit Staff</h4>

        <a href="{{ route('manager.staff.index') }}" class="btn btn-secondary btn-sm mb-3">
            &larr; Kembali ke daftar
        </a>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('manager.staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nama Staff</label>
                <input type="text"
                       name="name"
                       id="name"
                       class="form-control"
                       value="{{ old('name', $staff->name) }}"
                       required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Staff</label>
                <input type="email"
                       name="email"
                       id="email"
                       class="form-control"
                       value="{{ old('email', $staff->email) }}"
                       required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">
                    Password Baru
                    <small class="text-muted">(kosongkan jika tidak diubah)</small>
                </label>
                <input type="password"
                       name="password"
                       id="password"
                       class="form-control">
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection
