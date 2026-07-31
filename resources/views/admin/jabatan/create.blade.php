@extends('layouts.app')

@section('title','Tambah Jabatan')
@section('page-title','Tambah Jabatan')

@section('content')

<div class="card">

    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-plus-circle me-2"></i>
            Tambah Jabatan
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.jabatan.store') }}" method="POST">

            @csrf

            <div class="mb-3">
                <label class="form-label">Bidang</label>

                <select name="bidang_id"
                    class="form-select @error('bidang_id') is-invalid @enderror">

                    <option value="">-- Pilih Bidang --</option>

                    @foreach($bidangs as $bidang)

                    <option
                        value="{{ $bidang->id }}"
                        {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>

                        {{ $bidang->nama }}

                    </option>

                    @endforeach

                </select>

                @error('bidang_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Nama Jabatan</label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    class="form-control @error('nama') is-invalid @enderror">

                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror

            </div>

            <div class="mb-3">

                <label class="form-label">Deskripsi</label>

                <textarea
                    name="deskripsi"
                    rows="3"
                    class="form-control">{{ old('deskripsi') }}</textarea>

            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save"></i>
                Simpan
            </button>

            <a href="{{ route('admin.jabatan.index') }}"
                class="btn btn-secondary">

                Batal

            </a>

        </form>

    </div>

</div>

@endsection