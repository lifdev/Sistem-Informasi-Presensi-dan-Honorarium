@extends('layouts.app')

@section('title','Edit Bidang')
@section('page-title','Edit Bidang')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-7">

        <div class="card">

            <div class="card-header bg-white fw-bold">
                <i class="bi bi-pencil-square me-2"></i>
                Edit Bidang
            </div>

            <div class="card-body">

                <form action="{{ route('admin.bidang.update',$bidang) }}" method="POST">

                    @csrf
                    @method('PUT')

                    <div class="mb-3">

                        <label class="form-label">Nama Bidang</label>

                        <input
                            type="text"
                            name="nama"
                            class="form-control @error('nama') is-invalid @enderror"
                            value="{{ old('nama',$bidang->nama) }}"
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
                            class="form-control">{{ old('deskripsi',$bidang->deskripsi) }}</textarea>

                    </div>

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.bidang.index') }}"
                            class="btn btn-secondary">
                            Kembali
                        </a>

                        <button class="btn btn-warning">

                            <i class="bi bi-check-circle me-1"></i>

                            Update

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@endsection