@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard Admin')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#1e3a5f,#2e5fa3)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Total Karyawan Aktif</div>
                    <div class="fs-2 fw-bold">{{ $totalKaryawan }}</div>
                </div>
                <i class="bi bi-people fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#198754,#20c997)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Hadir Hari Ini</div>
                    <div class="fs-2 fw-bold">{{ $hadirHariIni }}</div>
                </div>
                <i class="bi bi-calendar-check fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#fd7e14,#ffc107)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Izin Pending</div>
                    <div class="fs-2 fw-bold">{{ $izinPending }}</div>
                </div>
                <i class="bi bi-envelope-exclamation fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#6f42c1,#d63384)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Honorarium Draft</div>
                    <div class="fs-2 fw-bold">{{ $honorariumDraft }}</div>
                </div>
                <i class="bi bi-cash-stack fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-lightning-charge text-warning me-2"></i>Aksi Cepat
            </div>
            <div class="card-body d-grid gap-2">
                <a href="{{ route('admin.karyawan.create') }}" class="btn btn-outline-primary">
                    <i class="bi bi-person-plus me-2"></i>Tambah Karyawan
                </a>
                <a href="{{ route('admin.presensi.rekap') }}" class="btn btn-outline-success">
                    <i class="bi bi-calendar-check me-2"></i>Rekap Presensi
                </a>
                <a href="{{ route('admin.izin.approval') }}" class="btn btn-outline-warning">
                    <i class="bi bi-envelope-check me-2"></i>Approval Izin
                    @if($izinPending > 0)
                    <span class="badge bg-danger ms-1">{{ $izinPending }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.honorarium.index') }}" class="btn btn-outline-purple">
                    <i class="bi bi-cash-stack me-2"></i>Generate Honorarium
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-info-circle text-info me-2"></i>Informasi Sistem
            </div>
            <div class="card-body">
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Tanggal</td>
                        <td class="fw-semibold">{{ now()->translatedFormat('l, d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jam</td>
                        <td class="fw-semibold" id="jam">{{ now()->format('H:i:s') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Login sebagai</td>
                        <td class="fw-semibold">{{ auth()->user()->name }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Role</td>
                        <td><span class="badge bg-primary">Admin</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    setInterval(() => {
        const now = new Date();
        document.getElementById('jam').textContent =
            now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
    }, 1000);
</script>
@endpush