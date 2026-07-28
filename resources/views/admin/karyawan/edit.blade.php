@extends('layouts.app')

@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-pencil text-warning me-2"></i>Edit Data Karyawan — {{ $karyawan->nama }}
            </div>
            <div class="card-body">
                <form action="{{ route('admin.karyawan.update', $karyawan) }}" method="POST">
                    @csrf @method('PUT')

                    <h6 class="fw-bold text-muted mb-3">Data Pribadi</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">NIP <span class="text-danger">*</span></label>
                            <input type="text" name="nip"
                                   class="form-control @error('nip') is-invalid @enderror"
                                   value="{{ old('nip', $karyawan->nip) }}" required>
                            @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama"
                                   class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama', $karyawan->nama) }}" required>
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

                <option value="{{ $bidang->id }}"
                    {{ $karyawan->jabatan->bidang_id == $bidang->id ? 'selected' : '' }}>

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

        <select
            name="jabatan_id"
            id="jabatan"
            class="form-select @error('jabatan_id') is-invalid @enderror"
            required>

            @foreach($jabatans as $jabatan)

                <option
                    value="{{ $jabatan->id }}"
                    data-bidang="{{ $jabatan->bidang_id }}"
                    {{ old('jabatan_id',$karyawan->jabatan_id)==$jabatan->id?'selected':'' }}>

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
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="L" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="no_hp"
                                   class="form-control"
                                   value="{{ old('no_hp', $karyawan->no_hp) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Masuk <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_masuk"
                                   class="form-control"
                                   value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk->format('Y-m-d')) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Alamat</label>
                            <input type="text" name="alamat"
                                   class="form-control"
                                   value="{{ old('alamat', $karyawan->alamat) }}">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="aktif"    {{ old('status', $karyawan->status) == 'aktif'    ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ old('status', $karyawan->status) == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <div class="alert alert-info small">
                        <i class="bi bi-info-circle me-1"></i>
                        Untuk mengubah email, password, atau role — silakan edit langsung di database atau tambahkan fitur tersebut.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-2"></i>Update Data
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

const bidang=document.getElementById('bidang');
const jabatan=document.getElementById('jabatan');

function filterJabatan(){

    let bidangId=bidang.value;

    [...jabatan.options].forEach(function(option){

        if(option.value==""){
            option.hidden=false;
            return;
        }

        option.hidden=option.dataset.bidang!=bidangId;

    });

}

filterJabatan();

bidang.addEventListener('change',function(){

    filterJabatan();

    jabatan.value="";

});

</script>
@endpush
@endsection