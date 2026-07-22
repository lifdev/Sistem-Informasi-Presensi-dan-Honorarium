@extends('layouts.app')

@section('title', 'Approval Izin')
@section('page-title', 'Approval Izin')

@section('content')

{{-- Tab Filter --}}
<div class="card">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-envelope-check text-warning me-2"></i>Daftar Pengajuan Izin
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Karyawan</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Alasan</th>
                        <th>Lampiran</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($izin as $i)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $i->karyawan->nama }}</div>
                            <div class="text-muted small">{{ $i->karyawan->jabatan }}</div>
                        </td>
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
                        <td>
                            <div>{{ $i->tanggal_mulai->format('d/m/Y') }}</div>
                            <div class="text-muted small">s/d {{ $i->tanggal_selesai->format('d/m/Y') }}</div>
                        </td>
                        <td>{{ $i->jumlahHari() }} hari</td>
                        <td class="text-truncate" style="max-width:160px" title="{{ $i->alasan }}">
                            {{ $i->alasan }}
                        </td>
                        <td>
                            @if($i->lampiran)
                            <a href="{{ asset('storage/'.$i->lampiran) }}" target="_blank"
                                class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-paperclip"></i>
                            </a>
                            @else
                            <span class="text-muted small">-</span>
                            @endif
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
                        <td>
                            @if($i->status === 'pending')
                            <div class="d-flex gap-1">
                                <form action="{{ auth()->user()->isAdmin()
                                            ? route('admin.izin.approve', $i)
                                            : route('pimpinan.izin.approve', $i) }}"
                                    method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm"
                                        onclick="return confirm('Setujui izin ini?')">
                                        <i class="bi bi-check-lg"></i> Setujui
                                    </button>
                                </form>
                                <form action="{{ auth()->user()->isAdmin()
                                            ? route('admin.izin.reject', $i)
                                            : route('pimpinan.izin.reject', $i) }}"
                                    method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tolak izin ini?')">
                                        <i class="bi bi-x-lg"></i> Tolak
                                    </button>
                                </form>
                            </div>
                            @else
                            <div class="text-muted small">
                                {{ $i->penyetuju?->name ?? '-' }}<br>
                                <span class="text-muted">{{ $i->disetujui_at?->format('d/m/Y H:i') }}</span>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-check-all fs-3 d-block mb-2"></i>
                            Tidak ada pengajuan izin yang perlu diproses.
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