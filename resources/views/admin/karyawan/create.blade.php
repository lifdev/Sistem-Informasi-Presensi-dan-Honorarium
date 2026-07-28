@extends('layouts.app')

@section('title', 'Tambah Karyawan')
@section('page-title', 'Tambah Karyawan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-person-plus text-primary me-2"></i>Form Tambah Karyawan
            </div>
            <div class="card-body">
                <form action="{{ route('admin.karyawan.store') }}" method="POST">
                    @csrf

                    <h6 class="fw-bold text-muted mb-3">Data Pribadi</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip"
                                   class="form-control @error('nip') is-invalid @enderror"
                                   value="{{ old('nip') }}" placeholder="Contoh: KRY003" required>
                            @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}" required>
                            @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Bidang
            <span class="text-danger">*</span>
        </label>

        <select id="bidang" class="form-select">
            <option value="">-- Pilih Bidang --</option>

            @foreach($bidangs as $bidang)
                <option value="{{ $bidang->id }}">
                    {{ $bidang->nama }}
                </option>
            @endforeach

        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label fw-semibold">
            Jabatan
            <span class="text-danger">*</span>
        </label>

        <select name="jabatan_id"
                id="jabatan"
                class="form-select @error('jabatan_id') is-invalid @enderror"
                required>

            <option value="">-- Pilih Jabatan --</option>

            @foreach($jabatans as $jabatan)

                <option
                    value="{{ $jabatan->id }}"
                    data-bidang="{{ $jabatan->bidang_id }}"
                    {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>

                    {{ $jabatan->nama }}

                </option>

            @endforeach

        </select>

        @error('jabatan_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk"
                                   class="form-control @error('tanggal_masuk') is-invalid @enderror"
                                   value="{{ old('tanggal_masuk') }}" required>
                            @error('tanggal_masuk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <input type="text" name="alamat"
                                   class="form-control @error('alamat') is-invalid @enderror"
                                   value="{{ old('alamat') }}">
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <hr>
                    <h6 class="fw-bold text-muted mb-3">Akun Login</h6>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Role <span class="text-danger">*</span></label>
                        <select name="role" class="form-select @error('role') is-invalid @enderror" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                            <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                            <option value="admin"    {{ old('role') == 'admin'    ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Karyawan
                        </button>
                        <a href="{{ route('admin.karyawan.index') }}" class="btn btn-outline-secondary px-4">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>

const bidang = document.getElementById('bidang');
const jabatan = document.getElementById('jabatan');

bidang.addEventListener('change', function(){

    let bidangId = this.value;

    [...jabatan.options].forEach(function(option){

        if(option.value == ""){
            option.hidden = false;
            return;
        }

        option.hidden = option.dataset.bidang != bidangId;

    });

    jabatan.value = "";

});

</script>
@endpush
@endsection