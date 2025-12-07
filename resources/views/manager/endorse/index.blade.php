@extends('layouts.app')

@section('title', 'Riwayat Influencer Terpilih - Endorse')

@section('content')

{{-- ===================== PRINT CSS ===================== --}}
<style>
    @media print {

        /* semua elemen dengan class no-print disembunyikan saat print */
        .no-print {
            display: none !important;
        }

        body {
            background: #ffffff !important;
        }

        .card {
            box-shadow: none !important;
            border: 1px solid #e0e0e0 !important;
        }

        .container,
        .main-container {
            max-width: 100% !important;
            width: 100% !important;
        }

        /* Biar tabel lebih bersih ketika print */
        table {
            font-size: 13px !important;
        }
    }
</style>

{{-- ===================== HEADER + BUTTON PRINT ===================== --}}
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h4 class="fw-bold mb-1">Riwayat Influencer Terpilih</h4>
        <p class="text-muted small mb-0">
            Daftar seluruh influencer yang dipilih oleh staff berdasarkan hasil WASPAS.
        </p>
    </div>

    {{-- Tombol Cetak --}}
    <div class="no-print">
        <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
            Cetak / Print
        </button>
    </div>
</div>

{{-- ===================== CARD WRAPPER ===================== --}}
<div class="card border-0 shadow-sm rounded-4">
    <div class="card-body p-4">

        {{-- ===================== SEARCH FORM ===================== --}}
        <form class="row g-2 mb-3 no-print" method="GET" action="{{ route('manager.endorse.index') }}">
            <div class="col-md-4">
                <input type="text" name="q" class="form-control form-control-sm"
                       placeholder="Cari influencer / platform / campaign..."
                       value="{{ $keyword }}">
            </div>
            <div class="col-md-3">
                <button class="btn btn-outline-secondary btn-sm">Cari</button>
                <a href="{{ route('manager.endorse.index') }}" class="btn btn-link btn-sm">Reset</a>
            </div>
        </form>

        {{-- ===================== TABLE ===================== --}}
        @if ($selected->isEmpty())
            <div class="alert alert-info mb-0">
                Belum ada influencer yang dipilih untuk endorsement.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>Influencer</th>
                        <th>Platform</th>
                        <th>Username</th>
                        <th>Nilai Akhir (Qi)</th>
                        <th>Perhitungan</th>
                        <th>Dipilih Oleh</th>
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
                            <td>{{ $item->history->user->name ?? '-' }}</td>
                            <td>{{ $item->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION (tidak ikut dicetak) --}}
            <div class="mt-3 no-print">
                {{ $selected->links() }}
            </div>
        @endif

    </div>
</div>

@endsection
