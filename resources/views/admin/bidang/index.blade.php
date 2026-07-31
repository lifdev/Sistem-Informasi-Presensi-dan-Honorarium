@extends('layouts.app')

@section('title', 'Data Bidang')
@section('page-title', 'Data Bidang')

@section('content')

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">
            <i class="bi bi-diagram-3 me-2"></i>Data Bidang
        </h5>

        <a href="{{ route('admin.bidang.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Tambah Bidang
        </a>
    </div>

    <div class="card-body p-0">

        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Nama Bidang</th>
                    <th>Deskripsi</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($bidangs as $bidang)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td class="fw-semibold">
                        {{ $bidang->nama }}
                    </td>

                    <td>
                        {{ $bidang->deskripsi ?? '-' }}
                    </td>

                    <td>

                        <a href="{{ route('admin.bidang.edit', $bidang) }}"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.bidang.destroy', $bidang) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus bidang ini?')">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center text-muted py-4">
                        Belum ada data bidang.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>
</div>

@endsection