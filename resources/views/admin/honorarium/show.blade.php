@extends('layouts.app')

@section('title', 'Detail Honorarium')
@section('page-title', 'Detail Honorarium')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">
                    <i class="bi bi-person-badge text-primary me-2"></i>
                    {{ $honorarium->karyawan->nama }}
                </span>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.laporan.slip', $honorarium) }}"
                        class="btn btn-danger btn-sm" target="_blank">
                        <i class="bi bi-printer me-1"></i>Cetak Slip
                    </a>
                    <a href="{{ route('admin.honorarium.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Info Karyawan --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Nama</td>
                                <td class="fw-semibold">{{ $honorarium->karyawan->nama }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">NIP</td>
                                <td>{{ $honorarium->karyawan->nip }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Bidang</td>
                                <td>{{ $honorarium->karyawan->jabatan?->bidang?->nama ?? '-' }}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Jabatan</td>
                                <td>{{ $honorarium->karyawan->jabatan?->nama ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Periode</td>
                                <td class="fw-semibold">{{ $honorarium->namaBulan() }} {{ $honorarium->tahun }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    <span class="badge bg-{{ $honorarium->status == 'final' ? 'success' : 'warning' }}">
                                        {{ ucfirst($honorarium->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                {{-- Rekap Kehadiran --}}
                <h6 class="fw-bold mb-3">Rekap Kehadiran</h6>
                <div class="row g-2 mb-4">
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 bg-success bg-opacity-10 rounded-3">
                            <div class="fs-3 fw-bold text-success">{{ $honorarium->total_hadir }}</div>
                            <div class="small text-muted">Hadir</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 bg-info bg-opacity-10 rounded-3">
                            <div class="fs-3 fw-bold text-info">{{ $honorarium->total_izin }}</div>
                            <div class="small text-muted">Izin</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 bg-warning bg-opacity-10 rounded-3">
                            <div class="fs-3 fw-bold text-warning">{{ $honorarium->total_sakit }}</div>
                            <div class="small text-muted">Sakit</div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center p-3 bg-danger bg-opacity-10 rounded-3">
                            <div class="fs-3 fw-bold text-danger">{{ $honorarium->total_alpha }}</div>
                            <div class="small text-muted">Alpha</div>
                        </div>
                    </div>
                </div>

                {{-- Rincian Gaji --}}
                <h6 class="fw-bold mb-3">Rincian Honorarium</h6>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td class="text-muted">Gaji Pokok</td>
                            <td class="text-end fw-semibold">Rp {{ number_format($honorarium->gaji_pokok, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                Tunjangan Kehadiran
                                <span class="text-muted small">({{ $honorarium->total_hadir }} hari)</span>
                            </td>
                            <td class="text-end text-success fw-semibold">
                                + Rp {{ number_format($honorarium->tunjangan, 0, ',', '.') }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">
                                Potongan
                                <span class="text-muted small">
                                    (Alpha: {{ $honorarium->total_alpha }},
                                    Izin: {{ $honorarium->total_izin }},
                                    Sakit: {{ $honorarium->total_sakit }} hari)
                                </span>
                            </td>
                            <td class="text-end text-danger fw-semibold">
                                - Rp {{ number_format($honorarium->total_potongan, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-success">
                            <th>Gaji Bersih</th>
                            <th class="text-end fs-5">
                                Rp {{ number_format($honorarium->gaji_bersih, 0, ',', '.') }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection