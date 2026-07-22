@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Karyawan')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#198754,#20c997)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Hadir Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $rekapBulanIni['hadir'] ?? 0 }}</div>
                </div>
                <i class="bi bi-check-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#0d6efd,#0dcaf0)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Izin Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $rekapBulanIni['izin'] ?? 0 }}</div>
                </div>
                <i class="bi bi-file-earmark-text fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#fd7e14,#ffc107)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Sakit Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $rekapBulanIni['sakit'] ?? 0 }}</div>
                </div>
                <i class="bi bi-heart-pulse fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#dc3545,#fd7e14)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Alpha Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $rekapBulanIni['alpha'] ?? 0 }}</div>
                </div>
                <i class="bi bi-x-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- Status Absen Hari Ini --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-fingerprint text-primary me-2"></i>Absen Hari Ini
            </div>
            <div class="card-body">
                @if($presensiHariIni)
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="badge bg-success fs-6 px-3 py-2">
                        <i class="bi bi-check-circle me-1"></i>Sudah Absen Masuk
                    </span>
                </div>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Jam Masuk</td>
                        <td class="fw-semibold">{{ $presensiHariIni->jam_masuk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Jam Pulang</td>
                        <td class="fw-semibold">
                            {{ $presensiHariIni->jam_pulang ?? '<span class="text-warning">Belum absen pulang</span>' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted">Status</td>
                        <td>
                            <span class="badge bg-success">{{ ucfirst($presensiHariIni->status) }}</span>
                        </td>
                    </tr>
                </table>
                @if(!$presensiHariIni->jam_pulang)
                <a href="{{ route('karyawan.presensi.index') }}" class="btn btn-warning btn-sm mt-3 w-100">
                    <i class="bi bi-box-arrow-left me-1"></i>Absen Pulang Sekarang
                </a>
                @endif
                @else
                <div class="text-center py-3">
                    <i class="bi bi-clock text-muted fs-1"></i>
                    <p class="text-muted mt-2">Anda belum absen hari ini.</p>
                    <a href="{{ route('karyawan.presensi.index') }}" class="btn btn-primary">
                        <i class="bi bi-fingerprint me-1"></i>Absen Sekarang
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Honorarium Terakhir --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-wallet2 text-success me-2"></i>Honorarium Terakhir
            </div>
            <div class="card-body">
                @if($honorariumTerakhir)
                <div class="text-center mb-3">
                    <div class="text-muted small">{{ $honorariumTerakhir->namaBulan() }} {{ $honorariumTerakhir->tahun }}</div>
                    <div class="fs-3 fw-bold text-success">
                        Rp {{ number_format($honorariumTerakhir->gaji_bersih, 0, ',', '.') }}
                    </div>
                    <span class="badge bg-{{ $honorariumTerakhir->status == 'final' ? 'success' : 'warning' }}">
                        {{ ucfirst($honorariumTerakhir->status) }}
                    </span>
                </div>
                <table class="table table-sm table-borderless mb-0">
                    <tr>
                        <td class="text-muted">Gaji Pokok</td>
                        <td class="text-end">Rp {{ number_format($honorariumTerakhir->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tunjangan</td>
                        <td class="text-end text-success">+ Rp {{ number_format($honorariumTerakhir->tunjangan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Potongan</td>
                        <td class="text-end text-danger">- Rp {{ number_format($honorariumTerakhir->total_potongan, 0, ',', '.') }}</td>
                    </tr>
                </table>
                <a href="{{ route('karyawan.honorarium.index') }}" class="btn btn-outline-success btn-sm mt-3 w-100">
                    Lihat Semua Honorarium
                </a>
                @else
                <div class="text-center py-3 text-muted">
                    <i class="bi bi-wallet2 fs-1"></i>
                    <p class="mt-2">Belum ada data honorarium.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    setInterval(() => {
        const now = new Date();
    }, 1000);
</script>
@endpush