@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Laporan & Ekspor')

@section('content')
<div class="row g-3">
    {{-- Laporan Presensi --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-calendar-check text-primary me-2"></i>Laporan Presensi
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold small">Bulan</label>
                        <select id="bulan-presensi" class="form-select form-select-sm">
                            @foreach(range(1,12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small">Tahun</label>
                        <select id="tahun-presensi" class="form-select form-select-sm">
                            @foreach(range(date('Y')-2, date('Y')) as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button onclick="exportPresensi('excel')" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel me-2"></i>Download Excel
                    </button>
                    <button onclick="exportPresensi('pdf')" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Laporan Honorarium --}}
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-cash-stack text-success me-2"></i>Laporan Honorarium
            </div>
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold small">Bulan</label>
                        <select id="bulan-honorarium" class="form-select form-select-sm">
                            @foreach(range(1,12) as $b)
                                <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold small">Tahun</label>
                        <select id="tahun-honorarium" class="form-select form-select-sm">
                            @foreach(range(date('Y')-2, date('Y')) as $t)
                                <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button onclick="exportHonorarium('excel')" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel me-2"></i>Download Excel
                    </button>
                    <button onclick="exportHonorarium('pdf')" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function exportPresensi(type) {
        const bulan = document.getElementById('bulan-presensi').value;
        const tahun = document.getElementById('tahun-presensi').value;
        const url   = type === 'excel'
            ? `{{ route('admin.laporan.presensi.excel') }}`
            : `{{ route('admin.laporan.presensi.pdf') }}`;
        window.location.href = url + `?bulan=${bulan}&tahun=${tahun}`;
    }

    function exportHonorarium(type) {
        const bulan = document.getElementById('bulan-honorarium').value;
        const tahun = document.getElementById('tahun-honorarium').value;
        const url   = type === 'excel'
            ? `{{ route('admin.laporan.honorarium.excel') }}`
            : `{{ route('admin.laporan.honorarium.pdf') }}`;
        window.location.href = url + `?bulan=${bulan}&tahun=${tahun}`;
    }
</script>
@endpush
