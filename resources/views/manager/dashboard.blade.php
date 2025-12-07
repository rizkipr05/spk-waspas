@extends('layouts.app')

@section('title', 'Dashboard Manager')

@section('content')
<style>
    .page-header {
        background: radial-gradient(circle at top left, #38bdf8 0, transparent 55%),
                    radial-gradient(circle at top right, #a855f7 0, transparent 55%),
                    linear-gradient(135deg, #020617, #020617 60%, #111827);
        border-radius: 1.5rem;
        padding: 1.75rem 1.5rem;
        color: #e5e7eb;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.6);
        position: relative;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .page-header::after {
        content: "";
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 0 120%, rgba(56, 189, 248, 0.18) 0, transparent 55%);
        opacity: 0.8;
        pointer-events: none;
    }

    .page-header-content {
        position: relative;
        z-index: 1;
    }

    .metric-card {
        border-radius: 1.2rem;
        border: 0;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.12);
        overflow: hidden;
        background: #ffffff;
    }

    .metric-card .card-body {
        padding: 1.2rem 1.4rem;
    }

    .metric-label {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: .12em;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }

    .metric-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
    }

    .metric-sub {
        font-size: 0.8rem;
        color: #9ca3af;
    }

    .metric-badge {
        font-size: 0.72rem;
        border-radius: 999px;
        padding: 0.1rem 0.5rem;
    }
</style>

<div class="page-header">
    <div class="page-header-content d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
        <div>
            <div class="d-inline-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill bg-info text-dark px-3 py-1">
                    Manager Dashboard
                </span>
                <span class="badge rounded-pill bg-dark border border-slate-500 text-slate-200 px-3 py-1">
                    Monitoring SPK Influencer (WASPAS)
                </span>
            </div>
            <h3 class="fw-semibold mb-1">
                Selamat datang, {{ $user->name }}
            </h3>
            <p class="mb-0 text-slate-200" style="max-width: 520px;">
                Pantau aktivitas staff, hasil perhitungan WASPAS, dan data influencer secara keseluruhan
                untuk pengambilan keputusan endorsement yang lebih terukur.
            </p>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Total Staff</div>
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="metric-value">{{ $staffCount }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Pengguna sistem
                    </span>
                </div>
                <div class="metric-sub">
                    Kelola akses staff di menu <strong>Kelola Staff</strong>.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Total Influencer</div>
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="metric-value">{{ $totalInfluencers }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Kandidat endorse
                    </span>
                </div>
                <div class="metric-sub">
                    Diinput & dikelola oleh staff.
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Kriteria Aktif</div>
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="metric-value">{{ $totalCriteria }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Bobot penilaian
                    </span>
                </div>
                <div class="metric-sub">
                    Menggambarkan aspek penilaian influencer (reach, ER, dsb).
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Riwayat Perhitungan</div>
                <div class="d-flex align-items-center justify-content-between mb-1">
                    <div class="metric-value">{{ $totalHistories }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Hasil WASPAS
                    </span>
                </div>
                <div class="metric-sub">
                    Lihat detail di menu <strong>Hasil WASPAS</strong>.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Ringkasan Fungsi</h6>
                <p class="text-muted small mb-2">
                    Sebagai manager, Anda dapat:
                </p>
                <ul class="small text-muted mb-0">
                    <li>
                        Mengelola akun staff yang bertugas menginput data dan menjalankan perhitungan WASPAS.
                    </li>
                    <li>
                        Memantau hasil perhitungan WASPAS untuk setiap campaign endorsement.
                    </li>
                    <li>
                        Melihat riwayat influencer yang telah dipilih berdasarkan rekomendasi sistem.
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Aksi Cepat</h6>
                <div class="d-grid gap-2">
                    <a href="{{ route('manager.staff.index') }}" class="btn btn-outline-dark btn-sm">
                        Kelola Staff
                    </a>
                    <a href="{{ route('manager.waspas.index') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Hasil WASPAS
                    </a>
                    <a href="{{ route('manager.endorse.index') }}" class="btn btn-outline-success btn-sm">
                        Riwayat Influencer Terpilih
                    </a>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Catatan</h6>
                <p class="small text-muted mb-0">
                    Data pada dashboard ini bersifat agregat (global) untuk seluruh staff.
                    Gunakan menu <strong>Hasil WASPAS</strong> dan <strong>Riwayat Endorse</strong> untuk melihat detail tiap perhitungan dan influencer yang dipilih.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
