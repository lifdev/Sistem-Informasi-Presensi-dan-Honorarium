@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')
@section('page-title', 'Dashboard Pimpinan')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#198754,#20c997)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Hadir Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $rekap['hadir'] ?? 0 }}</div>
                </div>
                <i class="bi bi-check-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="background: linear-gradient(135deg,#0dcaf0,#0d6efd)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small opacity-75">Izin Bulan Ini</div>
                    <div class="fs-2 fw-bold">{{ $rekap['izin'] ?? 0 }}</div>
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
                    <div class="fs-2 fw-bold">{{ $rekap['sakit'] ?? 0 }}</div>
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
                    <div class="fs-2 fw-bold">{{ $rekap['alpha'] ?? 0 }}</div>
                </div>
                <i class="bi bi-x-circle fs-1 opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
        <span><i class="bi bi-envelope-exclamation text-warning me-2"></i>Izin Menunggu Persetujuan</span>
        <a href="{{ route('pimpinan.izin.approval') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="card-body p-0">
        @if($izinPending->isEmpty())
        <div class="text-center text-muted py-4">
            <i class="bi bi-check-all fs-2"></i>
            <p class="mt-2 mb-0">Tidak ada izin yang menunggu persetujuan.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Karyawan</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Alasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($izinPending as $izin)
                    <tr>
                        <td class="fw-semibold">{{ $izin->karyawan->nama }}</td>
                        <td>
                            <span class="badge bg-{{ $izin->jenis == 'sakit' ? 'warning' : 'info' }}">
                                {{ ucfirst($izin->jenis) }}
                            </span>
                        </td>
                        <td>{{ $izin->tanggal_mulai->format('d/m/Y') }} — {{ $izin->tanggal_selesai->format('d/m/Y') }}</td>
                        <td class="text-truncate" style="max-width:150px">{{ $izin->alasan }}</td>
                        <td>
                            <form action="{{ route('pimpinan.izin.approve', $izin) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success"><i class="bi bi-check"></i></button>
                            </form>
                            <form action="{{ route('pimpinan.izin.reject', $izin) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-x"></i></button>
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