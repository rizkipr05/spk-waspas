@extends('layouts.app')

@section('title', 'Detail Hasil WASPAS')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="fw-semibold mb-1">Detail Hasil Perhitungan WASPAS</h4>
        <p class="text-muted mb-0 small">
            {{ $history->title }}
        </p>
    </div>
    <a href="{{ route('manager.waspas.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-3">
    <div class="card-body p-3 p-md-4">
        <div class="row g-3">
            <div class="col-md-4">
                <h6 class="fw-semibold mb-1">Informasi Perhitungan</h6>
                <dl class="mb-0 small">
                    <dt>Judul</dt>
                    <dd>{{ $history->title }}</dd>

                    <dt>Staff</dt>
                    <dd>{{ $history->user->name ?? '-' }}</dd>

                    <dt>Tanggal</dt>
                    <dd>{{ $history->created_at->format('d M Y H:i') }}</dd>

                    @if ($history->description)
                        <dt>Deskripsi</dt>
                        <dd>{{ $history->description }}</dd>
                    @endif
                </dl>
            </div>
            <div class="col-md-8">
                <h6 class="fw-semibold mb-2">Ringkasan Kriteria (Snapshot)</h6>

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
                                        <td>{{ !empty($c['is_active']) ? 'Aktif' : 'Non Aktif' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">
        <h6 class="fw-semibold mb-3">Ranking Influencer</h6>

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
                            <th>Status Pilihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td><strong>#{{ $item->rank }}</strong></td>
                                <td>{{ $item->influencer->name ?? '-' }}</td>
                                <td>{{ $item->influencer->platform ?? '-' }}</td>
                                <td>{{ $item->influencer->username ? '@'.$item->influencer->username : '-' }}</td>
                                <td>{{ number_format($item->final_score, 6) }}</td>
                                <td>
                                    @if ($item->selected)
                                        <span class="badge bg-success">Dipilih Endorse</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Dipilih</span>
                                    @endif
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
