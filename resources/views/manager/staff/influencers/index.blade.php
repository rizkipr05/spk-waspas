@extends('layouts.app')

@section('title', 'Data Influencer')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <h4 class="fw-semibold mb-1">Data Influencer</h4>
        <p class="text-muted mb-0 small">
            Kelola data influencer yang akan digunakan dalam perhitungan WASPAS.
        </p>
    </div>
    <a href="{{ route('staff.influencers.create') }}" class="btn btn-primary btn-sm">
        + Tambah Influencer
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
        {{-- Form cari --}}
        <form method="GET" action="{{ route('staff.influencers.index') }}" class="row g-2 align-items-center mb-3">
            <div class="col-md-4">
                <input
                    type="text"
                    name="q"
                    value="{{ $search ?? '' }}"
                    class="form-control form-control-sm"
                    placeholder="Cari nama / username / niche..."
                >
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-secondary btn-sm">
                    Cari
                </button>
                <a href="{{ route('staff.influencers.index') }}" class="btn btn-link btn-sm">
                    Reset
                </a>
            </div>
        </form>

        @if ($influencers->isEmpty())
            <div class="alert alert-info mb-0">
                Belum ada data influencer. Klik <strong>Tambah Influencer</strong> untuk menambahkan.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Platform</th>
                            <th>Followers</th>
                            <th>Engagement (%)</th>
                            <th>Niche</th>
                            <th style="width: 150px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($influencers as $i => $inf)
                            <tr>
                                <td>{{ $influencers->firstItem() + $i }}</td>
                                <td>{{ $inf->name }}</td>
                                <td>{{ $inf->username ?? '-' }}</td>
                                <td>{{ $inf->platform }}</td>
                                <td>{{ number_format($inf->followers) }}</td>
                                <td>{{ $inf->engagement_rate !== null ? number_format($inf->engagement_rate, 2) : '-' }}</td>
                                <td>{{ $inf->niche ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('staff.influencers.edit', $inf->id) }}"
                                       class="btn btn-sm btn-warning">
                                        Edit
                                    </a>
                                    <form action="{{ route('staff.influencers.destroy', $inf->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus influencer ini?');">
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

            <div class="mt-3">
                {{ $influencers->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
