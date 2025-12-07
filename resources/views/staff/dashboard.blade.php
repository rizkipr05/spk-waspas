@extends('layouts.app')

@section('title', 'Dashboard Staff')

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
        font-size: 1.4rem;
        font-weight: 700;
        color: #0f172a;
    }

    .metric-badge {
        font-size: 0.72rem;
        border-radius: 999px;
        padding: 0.1rem 0.5rem;
    }

    .chart-card {
        border-radius: 1.2rem;
        border: 0;
        box-shadow: 0 12px 35px rgba(15, 23, 42, 0.18);
    }
</style>

<div class="page-header mb-4">
    <div class="page-header-content d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3">
        <div>
            <div class="d-inline-flex align-items-center gap-2 mb-2">
                <span class="badge rounded-pill bg-info text-dark px-3 py-1">
                    Staff Dashboard
                </span>
                <span class="badge rounded-pill bg-dark border border-slate-500 text-slate-200 px-3 py-1">
                    WASPAS · Influencer Endorsement
                </span>
            </div>
            <h3 class="fw-semibold mb-1">
                Selamat datang, {{ $user->name }}
            </h3>
            <p class="mb-0 text-slate-200" style="max-width: 520px;">
                Kelola data influencer, kriteria &amp; bobot, dan lakukan perhitungan WASPAS
                untuk menentukan influencer terbaik yang layak di-endorse.
            </p>
        </div>

        <div class="bg-slate-900 bg-opacity-70 rounded-4 px-3 py-2 d-flex flex-column align-items-start">
            <span class="small text-slate-400 mb-1">Ringkasan cepat</span>
            <div class="d-flex flex-wrap gap-2">
                <span class="badge bg-slate-800 text-slate-100">
                    Influencer: <strong>{{ $totalInfluencers }}</strong>
                </span>
                <span class="badge bg-slate-800 text-slate-100">
                    Kriteria aktif: <strong>{{ $totalCriteria }}</strong>
                </span>
                <span class="badge bg-slate-800 text-slate-100">
                    Perhitungan WASPAS: <strong>{{ $totalHistories }}</strong>
                </span>
                <span class="badge bg-emerald-500 text-emerald-950">
                    Dipilih endorse: <strong>{{ $totalSelected }}</strong>
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ROW: METRIC CARDS --}}
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Total Influencer</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="metric-value">{{ $totalInfluencers }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Data kandidat
                    </span>
                </div>
                <small class="text-muted">
                    Kelola di menu <strong>Data Influencer</strong>.
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Kriteria Aktif</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="metric-value">{{ $totalCriteria }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Bobot WASPAS
                    </span>
                </div>
                <small class="text-muted">
                    Atur di menu <strong>Kriteria &amp; Bobot</strong>.
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Perhitungan WASPAS</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="metric-value">{{ $totalHistories }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Riwayat
                    </span>
                </div>
                <small class="text-muted">
                    Lihat di menu <strong>Perhitungan WASPAS</strong>.
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card metric-card">
            <div class="card-body">
                <div class="metric-label">Dipilih untuk Endorse</div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="metric-value">{{ $totalSelected }}</div>
                    <span class="metric-badge bg-light text-secondary">
                        Terbaik
                    </span>
                </div>
                <small class="text-muted">
                    Lihat di menu <strong>Influencer Terpilih</strong>.
                </small>
            </div>
        </div>
    </div>
</div>

{{-- ROW: CHART + QUICK ACTIONS --}}
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card chart-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="fw-semibold mb-0">Overview Perhitungan Terakhir</h6>
                        <small class="text-muted">
                            Jumlah influencer &amp; yang dipilih dari beberapa perhitungan WASPAS terakhir.
                        </small>
                    </div>
                </div>

                @if ($recentHistories->isEmpty())
                    <div class="alert alert-info mb-0">
                        Belum ada perhitungan WASPAS. Klik
                        <strong>Perhitungan WASPAS</strong> di menu untuk memulai.
                    </div>
                @else
                    <div style="height: 220px;">
                        <canvas id="waspasChart"></canvas>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-4 mb-3">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Aksi Cepat</h6>
                <p class="text-muted small mb-3">
                    Mulai alur kerja utama SPK influencer dalam satu klik.
                </p>
                <div class="d-grid gap-2">
                    <a href="{{ route('staff.influencers.index') }}" class="btn btn-outline-dark btn-sm">
                        Kelola Data Influencer
                    </a>
                    <a href="{{ route('staff.criteria.index') }}" class="btn btn-outline-dark btn-sm">
                        Kelola Kriteria &amp; Bobot
                    </a>
                    @if (Route::has('staff.waspas.create'))
                        <a href="{{ route('staff.waspas.create') }}" class="btn btn-primary btn-sm">
                            + Perhitungan WASPAS Baru
                        </a>
                    @endif
                    @if (Route::has('staff.waspas.selected'))
                        <a href="{{ route('staff.waspas.selected') }}" class="btn btn-outline-success btn-sm">
                            Lihat Influencer Terpilih
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h6 class="fw-semibold mb-2">Tips</h6>
                <ul class="small text-muted mb-0">
                    <li>Pastikan total bobot kriteria aktif mendekati <strong>1.0</strong>.</li>
                    <li>Gunakan WASPAS untuk membandingkan beberapa influencer dalam 1 campaign.</li>
                    <li>Tandai influencer yang dipilih untuk memudahkan pelacakan endorsement.</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if (!$recentHistories->isEmpty())
    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        (function () {
            var canvas = document.getElementById('waspasChart');
            if (!canvas) return;

            var ctx = canvas.getContext('2d');
            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Influencer dalam Perhitungan',
                            data: totalData,
                            borderWidth: 1
                        },
                        {
                            label: 'Dipilih untuk Endorse',
                            data: selectedData,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        })();
    </script>
@endif
@endsection
