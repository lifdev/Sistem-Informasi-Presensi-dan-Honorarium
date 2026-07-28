@extends('layouts.app')

@section('title', 'Pengaturan Jam Kerja')
@section('page-title', 'Pengaturan Jam Kerja')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-clock text-primary me-2"></i>Pengaturan Jam Masuk & Pulang
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pengaturan.jam.update') }}" method="POST">
                    @csrf @method('PUT')

                    {{-- Jam Masuk --}}
                    <div class="p-3 rounded-3 bg-success bg-opacity-10 border border-success mb-4">
                        <h6 class="fw-bold text-success mb-3">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Jam Absen Masuk
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Mulai Dari</label>
                                <input type="time" name="jam_masuk_mulai"
                                       class="form-control @error('jam_masuk_mulai') is-invalid @enderror"
                                       value="{{ old('jam_masuk_mulai', $jam->jam_masuk_mulai ?? '07:00') }}" required>
                                <div class="form-text">Jam paling awal karyawan bisa absen masuk.</div>
                                @error('jam_masuk_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Sampai</label>
                                <input type="time" name="jam_masuk_selesai"
                                       class="form-control @error('jam_masuk_selesai') is-invalid @enderror"
                                       value="{{ old('jam_masuk_selesai', $jam->jam_masuk_selesai ?? '09:00') }}" required>
                                <div class="form-text">Batas akhir absen masuk (setelahnya dianggap terlambat/alpha).</div>
                                @error('jam_masuk_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Jam Pulang --}}
                    <div class="p-3 rounded-3 bg-warning bg-opacity-10 border border-warning mb-4">
                        <h6 class="fw-bold text-warning mb-3">
                            <i class="bi bi-box-arrow-right me-2"></i>Jam Absen Pulang
                        </h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Mulai Dari</label>
                                <input type="time" name="jam_pulang_mulai"
                                       class="form-control @error('jam_pulang_mulai') is-invalid @enderror"
                                       value="{{ old('jam_pulang_mulai', $jam->jam_pulang_mulai ?? '16:00') }}" required>
                                <div class="form-text">Jam paling awal karyawan bisa absen pulang.</div>
                                @error('jam_pulang_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Sampai</label>
                                <input type="time" name="jam_pulang_selesai"
                                       class="form-control @error('jam_pulang_selesai') is-invalid @enderror"
                                       value="{{ old('jam_pulang_selesai', $jam->jam_pulang_selesai ?? '20:00') }}" required>
                                <div class="form-text">Batas akhir absen pulang.</div>
                                @error('jam_pulang_selesai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Preview --}}
                    <div class="alert alert-info small mb-4">
                        <i class="bi bi-info-circle me-1"></i>
                        <strong>Contoh:</strong> Jika jam masuk <strong>07:00 - 09:00</strong>,
                        karyawan hanya bisa absen masuk dalam rentang tersebut.
                        Di luar jam itu, tombol absen akan ditolak oleh sistem.
                    </div>

                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Simpan Pengaturan Jam
                    </button>
                </form>
            </div>
        </div>

        {{-- Info Jam Aktif --}}
        @if($jam->id ?? false)
        <div class="card mt-3">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-check-circle text-success me-2"></i>Jam Kerja Aktif Saat Ini
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="p-3 bg-success bg-opacity-10 rounded-3">
                            <i class="bi bi-box-arrow-in-right text-success fs-3"></i>
                            <div class="fw-bold mt-1">Absen Masuk</div>
                            <div class="text-success fs-5 fw-bold">
                                {{ \Carbon\Carbon::parse($jam->jam_masuk_mulai)->format('H:i') }}
                                —
                                {{ \Carbon\Carbon::parse($jam->jam_masuk_selesai)->format('H:i') }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-warning bg-opacity-10 rounded-3">
                            <i class="bi bi-box-arrow-right text-warning fs-3"></i>
                            <div class="fw-bold mt-1">Absen Pulang</div>
                            <div class="text-warning fs-5 fw-bold">
                                {{ \Carbon\Carbon::parse($jam->jam_pulang_mulai)->format('H:i') }}
                                —
                                {{ \Carbon\Carbon::parse($jam->jam_pulang_selesai)->format('H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection