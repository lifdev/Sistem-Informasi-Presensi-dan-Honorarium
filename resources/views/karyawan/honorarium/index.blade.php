@extends('layouts.app')

@section('title', 'Honorarium Saya')
@section('page-title', 'Honorarium Saya')

@section('content')
<div class="row g-3">
    @forelse($honorarium as $h)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">{{ $h->namaBulan() }} {{ $h->tahun }}</span>
                <span class="badge bg-{{ $h->status == 'final' ? 'success' : 'warning' }}">
                    {{ ucfirst($h->status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="text-muted small">Gaji Bersih</div>
                    <div class="fs-3 fw-bold text-success">
                        Rp {{ number_format($h->gaji_bersih, 0, ',', '.') }}
                    </div>
                </div>
                <div class="row text-center g-2 mb-3">
                    <div class="col-3">
                        <div class="small text-muted">Hadir</div>
                        <div class="fw-bold text-success">{{ $h->total_hadir }}</div>
                    </div>
                    <div class="col-3">
                        <div class="small text-muted">Izin</div>
                        <div class="fw-bold text-info">{{ $h->total_izin }}</div>
                    </div>
                    <div class="col-3">
                        <div class="small text-muted">Sakit</div>
                        <div class="fw-bold text-warning">{{ $h->total_sakit }}</div>
                    </div>
                    <div class="col-3">
                        <div class="small text-muted">Alpha</div>
                        <div class="fw-bold text-danger">{{ $h->total_alpha }}</div>
                    </div>
                </div>
                <table class="table table-sm table-borderless mb-0 small">
                    <tr>
                        <td class="text-muted">Gaji Pokok</td>
                        <td class="text-end">Rp {{ number_format($h->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Tunjangan</td>
                        <td class="text-end text-success">+ Rp {{ number_format($h->tunjangan, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted">Potongan</td>
                        <td class="text-end text-danger">- Rp {{ number_format($h->total_potongan, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center text-muted py-5">
                <i class="bi bi-wallet2 fs-1 d-block mb-3"></i>
                Belum ada data honorarium.
            </div>
        </div>
    </div>
    @endforelse
</div>

@if($honorarium->hasPages())
<div class="mt-3">{{ $honorarium->links() }}</div>
@endif
@endsection