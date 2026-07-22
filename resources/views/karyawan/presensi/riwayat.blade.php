@extends('layouts.app')

@section('title', 'Riwayat Presensi')
@section('page-title', 'Riwayat Presensi')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="fw-semibold"><i class="bi bi-clock-history text-primary me-2"></i>Riwayat Presensi Saya</span>
        <form method="GET" class="d-flex gap-2">
            <select name="bulan" class="form-select form-select-sm">
                @foreach(range(1,12) as $b)
                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                    {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                </option>
                @endforeach
            </select>
            <select name="tahun" class="form-select form-select-sm">
                @foreach(range(date('Y')-2, date('Y')) as $t)
                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary btn-sm">Filter</button>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($presensi as $p)
                    <tr>
                        <td>{{ $p->tanggal->translatedFormat('d M Y') }}</td>
                        <td>{{ $p->jam_masuk ?? '-' }}</td>
                        <td>{{ $p->jam_pulang ?? '-' }}</td>
                        <td>
                            @php
                            $badge = match($p->status) {
                            'hadir' => 'success',
                            'izin' => 'info',
                            'sakit' => 'warning',
                            'alpha' => 'danger',
                            default => 'secondary'
                            };
                            @endphp
                            <span class="badge bg-{{ $badge }}">{{ ucfirst($p->status) }}</span>
                        </td>
                        <td class="text-muted small">{{ $p->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                            Tidak ada data presensi untuk bulan ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($presensi->hasPages())
    <div class="card-footer bg-white">
        {{ $presensi->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection