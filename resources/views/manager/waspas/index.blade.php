@extends('layouts.app')

@section('title', 'Hasil Perhitungan WASPAS')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-semibold mb-1">Hasil Perhitungan WASPAS</h4>
        <p class="text-muted mb-0 small">
            Rekap seluruh perhitungan WASPAS yang dilakukan oleh staff.
        </p>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">

        {{-- Form Pencarian --}}
        <form method="GET" action="{{ route('manager.waspas.index') }}" class="row g-2 align-items-center mb-3">
            <div class="col-md-4">
                <input type="text"
                       name="q"
                       value="{{ $keyword }}"
                       class="form-control form-control-sm"
                       placeholder="Cari judul perhitungan atau nama staff...">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    Cari
                </button>
                <a href="{{ route('manager.waspas.index') }}" class="btn btn-link btn-sm">
                    Reset
                </a>
            </div>
        </form>

        @if ($histories->isEmpty())
            <div class="alert alert-info mb-0">
                Belum ada perhitungan WASPAS yang tercatat.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Judul Perhitungan</th>
                            <th>Staff</th>
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
                                <td>{{ $h->user->name ?? '-' }}</td>
                                <td>{{ $h->items_count }}</td>
                                <td>{{ $h->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('manager.waspas.show', $h->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Lihat Detail
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
