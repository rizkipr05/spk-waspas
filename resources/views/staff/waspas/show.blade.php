@extends('layouts.app')

@section('title', 'Hasil WASPAS')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="fw-semibold mb-1">Hasil Perhitungan WASPAS</h4>
        <p class="text-muted mb-0 small">
            {{ $history->title }} &middot; 
            <span class="text-muted">
                {{ $history->created_at->format('d M Y H:i') }}
            </span>
        </p>
    </div>
    <a href="{{ route('staff.waspas.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali ke Riwayat
    </a>
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
@endif

@if ($history->description)
    <div class="alert alert-info small">
        <strong>Deskripsi:</strong> {{ $history->description }}
    </div>
@endif

{{-- Ringkasan Kriteria --}}
<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body p-3 p-md-4">
        <h6 class="fw-semibold mb-2">Ringkasan Kriteria</h6>
        @php
            $criteria = $history->criteria_snapshot ?? [];
        @endphp

        @if (empty($criteria))
            <p class="text-muted small mb-0">
                Snapshot kriteria tidak tersedia.
            </p>
        @else
            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Jenis</th>
                            <th>Bobot</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($criteria as $c)
                            <tr>
                                <td>{{ $c['code'] }}</td>
                                <td>{{ $c['name'] }}</td>
                                <td>{{ $c['type'] === 'benefit' ? 'Benefit' : 'Cost' }}</td>
                                <td>{{ number_format($c['weight'], 4) }}</td>
                                <td>
                                    {{ !empty($c['is_active']) ? 'Aktif' : 'Non Aktif' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Tabel Ranking Influencer --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">
        <h6 class="fw-semibold mb-3">Ranking Influencer (Hasil WASPAS)</h6>

        @if ($items->isEmpty())
            <p class="text-muted mb-0">Tidak ada data hasil.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Peringkat</th>
                            <th>Influencer</th>
                            <th>Platform</th>
                            <th>Username</th>
                            <th>Nilai Akhir (Qi)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td><strong>#{{ $item->rank }}</strong></td>

                                <td>{{ $item->influencer->name ?? '-' }}</td>
                                <td>{{ $item->influencer->platform ?? '-' }}</td>
                                <td>{{ $item->influencer->username ? '@' . $item->influencer->username : '-' }}</td>
                                <td>{{ number_format($item->final_score, 6) }}</td>

                                {{-- STATUS DIPILIH --}}
                                <td>
                                    @if ($item->selected)
                                        <span class="badge bg-success">Dipilih</span>
                                    @else
                                        <span class="badge bg-secondary">Belum</span>
                                    @endif
                                </td>

                                {{-- TOMBOL ACTION --}}
                                <td>
                                    <form action="{{ route('staff.waspas.toggle', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm {{ $item->selected ? 'btn-danger' : 'btn-primary' }}">
                                            {{ $item->selected ? 'Batal Pilih' : 'Pilih Endorse' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
