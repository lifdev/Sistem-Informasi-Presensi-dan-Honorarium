<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Presensi & Honorarium')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f0f2f5;
        }

        .sidebar {
            min-height: 100vh;
            background: #1e3a5f;
            color: #fff;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            color: #cdd8e3;
            padding: .6rem 1.2rem;
            border-radius: 6px;
            margin: 2px 8px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: #2e5fa3;
            color: #fff;
        }

        .sidebar .nav-link i {
            width: 20px;
        }

        .sidebar .brand {
            padding: 1.2rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-bottom: 1px solid #2e5fa3;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .topbar {
            background: #fff;
            padding: .75rem 1.5rem;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card {
            border: none;
            box-shadow: 0 1px 4px rgba(0, 0, 0, .08);
            border-radius: 10px;
        }

        .stat-card {
            border-radius: 12px;
            padding: 1.2rem;
            color: #fff;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="brand">
            <i class="bi bi-building me-2"></i>Presensi App
        </div>
        <nav class="nav flex-column mt-2">
            @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.karyawan.index') }}" class="nav-link {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Karyawan
            </a>
            <a href="{{ route('admin.presensi.rekap') }}" class="nav-link {{ request()->routeIs('admin.presensi.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Presensi
            </a>
            <a href="{{ route('admin.izin.approval') }}" class="nav-link {{ request()->routeIs('admin.izin.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-check"></i> Izin
            </a>
            <a href="{{ route('admin.honorarium.index') }}" class="nav-link {{ request()->routeIs('admin.honorarium.*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Honorarium
            </a>
            <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan
            </a>
            <hr style="border-color:#2e5fa3">
            <a href="{{ route('admin.pengaturan.gaji') }}" class="nav-link {{ request()->routeIs('admin.pengaturan.gaji*') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Pengaturan Gaji
            </a>
            <a href="{{ route('admin.pengaturan.lokasi') }}" class="nav-link {{ request()->routeIs('admin.pengaturan.lokasi*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt"></i> Pengaturan Lokasi
            </a>

            @elseif(auth()->user()->isPimpinan())
            <a href="{{ route('pimpinan.dashboard') }}" class="nav-link {{ request()->routeIs('pimpinan.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('pimpinan.izin.approval') }}" class="nav-link {{ request()->routeIs('pimpinan.izin.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-check"></i> Approval Izin
            </a>
            <a href="{{ route('pimpinan.presensi.rekap') }}" class="nav-link {{ request()->routeIs('pimpinan.presensi.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i> Rekap Presensi
            </a>
            <a href="{{ route('pimpinan.honorarium.index') }}" class="nav-link {{ request()->routeIs('pimpinan.honorarium.*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i> Honorarium
            </a>

            @elseif(auth()->user()->isKaryawan())
            <a href="{{ route('karyawan.dashboard') }}" class="nav-link {{ request()->routeIs('karyawan.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('karyawan.presensi.index') }}" class="nav-link {{ request()->routeIs('karyawan.presensi.index') ? 'active' : '' }}">
                <i class="bi bi-fingerprint"></i> Absen
            </a>
            <a href="{{ route('karyawan.presensi.riwayat') }}" class="nav-link {{ request()->routeIs('karyawan.presensi.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Presensi
            </a>
            <a href="{{ route('karyawan.izin.index') }}" class="nav-link {{ request()->routeIs('karyawan.izin.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text"></i> Izin
            </a>
            <a href="{{ route('karyawan.honorarium.index') }}" class="nav-link {{ request()->routeIs('karyawan.honorarium.*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i> Honorarium
            </a>
            @endif
        </nav>
    </div>

    {{-- Main Content --}}
    <div class="main-content">
        <div class="topbar">
            <span class="fw-semibold">@yield('page-title', 'Dashboard')</span>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small">{{ auth()->user()->name }}</span>
                <span class="badge bg-primary">{{ ucfirst(auth()->user()->role) }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>