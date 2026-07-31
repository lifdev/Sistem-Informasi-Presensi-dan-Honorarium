@extends('layouts.app')

@section('title','Edit Jabatan')
@section('page-title','Edit Jabatan')

@section('content')

<div class="card">

    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-pencil-square me-2"></i>
            Edit Jabatan
        </h5>
    </div>

    <div class="card-body">

        <form action="{{ route('admin.jabatan.update',$jabatan) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">

                <label class="form-label">Bidang</label>

                <select
                    name="bidang_id"
                    class="form-select @error('bidang_id') is-invalid @enderror">

                    @foreach($bidangs as $bidang)

                    <option
                        value="{{ $bidang->id }}"
                        {{ old('bidang_id',$jabatan->bidang_id)==$bidang->id ? 'selected':'' }}>

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
                    value="{{ old('nama',$jabatan->nama) }}"
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
                    class="form-control">{{ old('deskripsi',$jabatan->deskripsi) }}</textarea>

            </div>

            <button class="btn btn-primary">
                <i class="bi bi-save"></i>
                Update
            </button>

            <a href="{{ route('admin.jabatan.index') }}"
                class="btn btn-secondary">
                Batal
            </a>

        </form>

    </div>

</div>

@endsection