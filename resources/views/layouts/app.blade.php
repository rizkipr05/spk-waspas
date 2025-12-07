<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SPK Influencer - WASPAS')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');

        body {
            background: #f3f4f6;
            min-height: 100vh;
            font-family: 'Outfit', sans-serif;
        }

        .navbar-custom {
            background: linear-gradient(90deg, #020617, #111827, #0f172a);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .navbar-shadow {
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.5);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.04em;
        }

        .nav-link {
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        /* User Profile Dropdown */
        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #38bdf8, #a855f7);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            color: #0f172a;
        }

        .user-name-sm {
            max-width: 120px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.85rem;
        }

        .role-badge {
            font-size: 0.7rem;
            padding: 0.2rem 0.55rem;
            border-radius: 999px;
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .dropdown-menu {
            font-size: 0.9rem;
            border: 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .dropdown-header {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: .12em;
        }

        .main-container {
            padding-top: 1.75rem;
            padding-bottom: 2rem;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark navbar-custom navbar-shadow sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
            Influencer <span class="text-info">WASPAS</span>
        </a>

        {{-- Toggle for mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        @php
            /** @var \App\Models\User|null $user */
            $user = auth()->user();
        @endphp

        <div class="collapse navbar-collapse" id="mainNavbar">

            {{-- LEFT MENU --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth
                    {{-- ============================
                         MENU MANAGER
                    ============================== --}}
                    @if ($user && $user->role === 'manager')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('manager.dashboard') ? 'active' : '' }}"
                               href="{{ route('manager.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('manager.staff.*') ? 'active' : '' }}"
                               href="{{ route('manager.staff.index') }}">
                                Kelola Staff
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('manager.waspas.*') ? 'active' : '' }}"
                               href="{{ route('manager.waspas.index') }}">
                                Hasil WASPAS
                            </a>
                        </li>
                        <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manager.endorse.*') ? 'active' : '' }}"
                        href="{{ route('manager.endorse.index') }}">
                            Riwayat Endorse
                           </a>
                        </li>

                    @endif

                    {{-- ============================
                         MENU STAFF
                    ============================== --}}
                    @if ($user && $user->role === 'staff')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
                               href="{{ route('staff.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('staff.influencers.*') ? 'active' : '' }}"
                               href="{{ route('staff.influencers.index') }}">
                                Data Influencer
                            </a>
                        </li>

                        @if (Route::has('staff.criteria.index'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.criteria.*') ? 'active' : '' }}"
                                   href="{{ route('staff.criteria.index') }}">
                                    Kriteria & Bobot
                                </a>
                            </li>
                        @endif

                        @if (Route::has('staff.waspas.index'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.waspas.*') ? 'active' : '' }}"
                                   href="{{ route('staff.waspas.index') }}">
                                    Perhitungan WASPAS
                                </a>
                            </li>
                        @endif

                        @if (Route::has('staff.waspas.selected'))
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('staff.waspas.selected') ? 'active' : '' }}"
                                   href="{{ route('staff.waspas.selected') }}">
                                    Influencer Terpilih
                                </a>
                            </li>
                        @endif
                    @endif
                @endauth
            </ul>

            {{-- RIGHT SIDE: Profile --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link d-flex align-items-center gap-2 dropdown-toggle"
                           href="#" id="userDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">

                            <span class="user-avatar">
                                {{ strtoupper(mb_substr($user->name ?? 'U', 0, 1)) }}
                            </span>

                            <span class="d-none d-lg-flex flex-column align-items-start">
                                <span class="user-name-sm text-white-90">{{ $user->name }}</span>
                                <span class="role-badge bg-info text-dark mt-1">{{ $user->role }}</span>
                            </span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header text-muted">
                                {{ $user->email }}
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    Pengaturan Akun
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>

                @else
                    <li class="nav-item me-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-info btn-sm">Register</a>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>

<div class="container main-container">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
