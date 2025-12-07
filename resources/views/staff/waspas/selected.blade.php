@extends('layouts.app')

@section('title', 'Influencer Terpilih')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-semibold">Influencer Terpilih untuk Endorse</h4>

    <a href="{{ route('staff.waspas.index') }}" class="btn btn-secondary btn-sm">
        &larr; Kembali
    </a>
</div>

@if ($selected->isEmpty())
    <div class="alert alert-info">
        Belum ada influencer yang dipilih untuk endorse.
    </div>
@else
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-3 p-md-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nama</th>
                        <th>Platform</th>
                        <th>Username</th>
                        <th>Skor (Qi)</th>
                        <th>Perhitungan</th>
                        <th>Tanggal Dipilih</th>
                    </tr>
                </thead>

                <tbody>
                @foreach ($selected as $item)
                    <tr>
                        <td>{{ $item->influencer->name }}</td>
                        <td>{{ $item->influencer->platform }}</td>
                        <td>{{ $item->influencer->username ?? '-' }}</td>
                        <td>{{ number_format($item->final_score, 6) }}</td>
                        <td>{{ $item->history->title }}</td>
                        <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endif
@endsection
