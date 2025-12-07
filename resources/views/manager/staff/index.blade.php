@extends('layouts.app')

@section('title', 'Kelola Staff')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Kelola Akun Staff</h4>
    <a href="{{ route('manager.staff.create') }}" class="btn btn-primary btn-sm">
        + Tambah Staff
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@if ($staffs->isEmpty())
    <div class="alert alert-info">
        Belum ada data staff. Klik <strong>Tambah Staff</strong> untuk menambah.
    </div>
@else
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Dibuat</th>
                            <th style="width: 170px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffs as $i => $staff)
                            <tr>
                                <td>{{ $staffs->firstItem() + $i }}</td>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('manager.staff.edit', $staff->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('manager.staff.destroy', $staff->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus staff ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $staffs->links() }}
        </div>
    </div>
@endif
@endsection
