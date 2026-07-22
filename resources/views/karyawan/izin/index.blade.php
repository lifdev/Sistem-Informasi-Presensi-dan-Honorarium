@extends('layouts.app')

@section('title', 'Izin Saya')
@section('page-title', 'Izin Saya')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-file-earmark-text text-primary me-2"></i>Riwayat Pengajuan Izin</span>
        <a href="{{ route('karyawan.izin.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-lg me-1"></i>Ajukan Izin
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Jenis</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Durasi</th>
                        <th>Alasan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izin as $i)
                    <tr>
                        <td>
                            @php
                            $jenisColor = match($i->jenis) {
                            'sakit' => 'warning',
                            'cuti' => 'info',
                            default => 'primary'
                            };
                            @endphp
                            <span class="badge bg-{{ $jenisColor }}">{{ ucfirst($i->jenis) }}</span>
                        </td>
                        <td>{{ $i->tanggal_mulai->format('d/m/Y') }}</td>
                        <td>{{ $i->tanggal_selesai->format('d/m/Y') }}</td>
                        <td>{{ $i->jumlahHari() }} hari</td>
                        <td class="text-truncate" style="max-width:180px" title="{{ $i->alasan }}">
                            {{ $i->alasan }}
                        </td>
                        <td>
                            @php
                            $statusColor = match($i->status) {
                            'disetujui' => 'success',
                            'ditolak' => 'danger',
                            default => 'warning'
                            };
                            @endphp
                            <span class="badge bg-{{ $statusColor }}">{{ ucfirst($i->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-file-earmark-x fs-3 d-block mb-2"></i>
                            Belum ada pengajuan izin.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($izin->hasPages())
    <div class="card-footer bg-white">
        {{ $izin->links() }}
    </div>
    @endif
</div>
@endsection