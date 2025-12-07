@extends('layouts.app')

@section('title', 'Perhitungan WASPAS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-semibold mb-1">Riwayat Perhitungan WASPAS</h4>
        <p class="text-muted mb-0 small">
            Daftar perhitungan WASPAS yang pernah dilakukan oleh Anda (staff).
        </p>
    </div>
    <a href="{{ route('staff.waspas.create') }}" class="btn btn-primary btn-sm">
        + Perhitungan Baru
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">
        @if ($histories->isEmpty())
            <div class="alert alert-info mb-0">
                Belum ada riwayat perhitungan WASPAS. Klik <strong>Perhitungan Baru</strong> untuk memulai.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Jumlah Influencer</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($histories as $i => $h)
                        <tr>
                            <td>{{ $histories->firstItem() + $i }}</td>
                            <td>{{ $h->title }}</td>
                            <td>{{ $h->items_count }}</td>
                            <td>{{ $h->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('staff.waspas.show', $h->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Lihat Hasil
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $histories->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
