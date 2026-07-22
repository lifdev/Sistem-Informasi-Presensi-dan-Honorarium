@extends('layouts.app')

@section('title', 'Honorarium')
@section('page-title', 'Manajemen Honorarium')

@section('content')
{{-- Form Generate --}}
<div class="card mb-3">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-gear text-primary me-2"></i>Generate Honorarium
    </div>
    <div class="card-body">
        <form action="{{ route('admin.honorarium.generate') }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-sm-4">
                <label class="form-label fw-semibold">Bulan</label>
                <select name="bulan" class="form-select">
                    @foreach(range(1,12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4">
                <label class="form-label fw-semibold">Tahun</label>
                <select name="tahun" class="form-select">
                    @foreach(range(date('Y')-2, date('Y')) as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary w-100"
                    onclick="return confirm('Generate honorarium untuk semua karyawan aktif?')">
                    <i class="bi bi-lightning-charge me-1"></i>Generate
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Tabel Honorarium --}}
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="fw-semibold">
            <i class="bi bi-cash-stack text-success me-2"></i>
            Honorarium —
            {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}
        </span>
        <div class="d-flex gap-2">
            @if($honorarium->isNotEmpty())
            <form action="{{ route('admin.honorarium.finalize') }}" method="POST">
                @csrf
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <button type="submit" class="btn btn-success btn-sm"
                    onclick="return confirm('Finalisasi honorarium bulan ini? Data tidak bisa diubah setelah finalisasi.')">
                    <i class="bi bi-check-circle me-1"></i>Finalisasi
                </button>
            </form>
            <a href="{{ route('admin.laporan.honorarium.excel', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
                class="btn btn-outline-success btn-sm">
                <i class="bi bi-file-earmark-excel me-1"></i>Excel
            </a>
            <a href="{{ route('admin.laporan.honorarium.pdf', ['bulan'=>$bulan,'tahun'=>$tahun]) }}"
                class="btn btn-outline-danger btn-sm">
                <i class="bi bi-file-earmark-pdf me-1"></i>PDF
            </a>
            @endif
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Karyawan</th>
                        <th class="text-center">Hadir</th>
                        <th class="text-center">Izin</th>
                        <th class="text-center">Sakit</th>
                        <th class="text-center">Alpha</th>
                        <th class="text-end">Gaji Pokok</th>
                        <th class="text-end">Tunjangan</th>
                        <th class="text-end">Potongan</th>
                        <th class="text-end">Gaji Bersih</th>
                        <th class="text-center">Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($honorarium as $h)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $h->karyawan->nama }}</div>
                            <div class="text-muted small">{{ $h->karyawan->jabatan }}</div>
                        </td>
                        <td class="text-center"><span class="badge bg-success">{{ $h->total_hadir }}</span></td>
                        <td class="text-center"><span class="badge bg-info">{{ $h->total_izin }}</span></td>
                        <td class="text-center"><span class="badge bg-warning">{{ $h->total_sakit }}</span></td>
                        <td class="text-center"><span class="badge bg-danger">{{ $h->total_alpha }}</span></td>
                        <td class="text-end">Rp {{ number_format($h->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="text-end text-success">+ Rp {{ number_format($h->tunjangan, 0, ',', '.') }}</td>
                        <td class="text-end text-danger">- Rp {{ number_format($h->total_potongan, 0, ',', '.') }}</td>
                        <td class="text-end fw-bold">Rp {{ number_format($h->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $h->status == 'final' ? 'success' : 'warning' }}">
                                {{ ucfirst($h->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.honorarium.show', $h) }}"
                                class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.laporan.slip', $h) }}"
                                class="btn btn-outline-danger btn-sm" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                            <i class="bi bi-cash-stack fs-3 d-block mb-2"></i>
                            Belum ada data. Klik <strong>Generate</strong> untuk membuat honorarium.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                @if($honorarium->isNotEmpty())
                <tfoot class="table-light fw-semibold">
                    <tr>
                        <td colspan="8" class="text-end">Total Pengeluaran:</td>
                        <td class="text-end text-success">
                            Rp {{ number_format($honorarium->sum('gaji_bersih'), 0, ',', '.') }}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
    @if($honorarium->hasPages())
    <div class="card-footer bg-white">
        {{ $honorarium->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection