@extends('layouts.app')

@section('title','Tambah Bidang')
@section('page-title','Tambah Bidang')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-7">

        <div class="card">

            <div class="card-header bg-white fw-bold">
                <i class="bi bi-plus-circle me-2"></i>
                Tambah Bidang
            </div>

            <div class="card-body">

                <form action="{{ route('admin.bidang.store') }}" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Nama Bidang</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama') }}"
                            required>

                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Deskripsi
                        </label>

                        <textarea
                            name="deskripsi"
                            rows="4"
                            class="form-control">{{ old('deskripsi') }}</textarea>

                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.bidang.index') }}"
                            class="btn btn-secondary">

                            Kembali

                        </a>

                        <button class="btn btn-primary">

                            <i class="bi bi-save me-1"></i>

                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection