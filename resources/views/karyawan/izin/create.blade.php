@extends('layouts.app')

@section('title', 'Ajukan Izin')
@section('page-title', 'Ajukan Izin')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-file-earmark-plus text-primary me-2"></i>Form Pengajuan Izin
            </div>
            <div class="card-body">
                <form action="{{ route('karyawan.izin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Jenis Izin <span class="text-danger">*</span></label>
                        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="izin" {{ old('jenis') == 'izin'  ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                            <option value="cuti" {{ old('jenis') == 'cuti'  ? 'selected' : '' }}>Cuti</option>
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai"
                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                value="{{ old('tanggal_mulai') }}"
                                min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Selesai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_selesai"
                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai') }}"
                                min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- Hitung durasi otomatis --}}
                    <div class="alert alert-info py-2 small mb-3" id="durasi-info" style="display:none!important">
                        <i class="bi bi-info-circle me-1"></i>
                        Durasi: <strong id="durasi-hari">0</strong> hari
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan <span class="text-danger">*</span></label>
                        <textarea name="alasan" rows="4"
                            class="form-control @error('alasan') is-invalid @enderror"
                            placeholder="Tuliskan alasan izin..." required>{{ old('alasan') }}</textarea>
                        @error('alasan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Lampiran <span class="text-muted small">(opsional)</span></label>
                        <input type="file" name="lampiran"
                            class="form-control @error('lampiran') is-invalid @enderror"
                            accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Format: PDF, JPG, PNG. Maks 2MB. (Surat dokter, dsb.)</div>
                        @error('lampiran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Kirim Pengajuan
                        </button>
                        <a href="{{ route('karyawan.izin.index') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const tglMulai = document.querySelector('[name="tanggal_mulai"]');
    const tglSelesai = document.querySelector('[name="tanggal_selesai"]');
    const durasiInfo = document.getElementById('durasi-info');
    const durasiHari = document.getElementById('durasi-hari');

    function hitungDurasi() {
        if (tglMulai.value && tglSelesai.value) {
            const start = new Date(tglMulai.value);
            const end = new Date(tglSelesai.value);
            const diff = Math.round((end - start) / (1000 * 60 * 60 * 24)) + 1;
            if (diff > 0) {
                durasiHari.textContent = diff;
                durasiInfo.style.removeProperty('display');
            }
        }
    }

    tglMulai.addEventListener('change', () => {
        tglSelesai.min = tglMulai.value;
        hitungDurasi();
    });
    tglSelesai.addEventListener('change', hitungDurasi);
</script>
@endpush