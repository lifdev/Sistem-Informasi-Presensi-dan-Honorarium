@extends('layouts.app')

@section('title','Data Jabatan')
@section('page-title','Data Jabatan')

@section('content')

<div class="card">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0 fw-bold">
            <i class="bi bi-person-badge me-2"></i>
            Data Jabatan
        </h5>

        <a href="{{ route('admin.jabatan.create') }}"
            class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i>
            Tambah Jabatan
        </a>

    </div>

    <div class="card-body p-0">

        <table class="table table-hover align-middle mb-0">

            <thead class="table-light">
                <tr>
                    <th width="60">No</th>
                    <th>Bidang</th>
                    <th>Nama Jabatan</th>
                    <th>Deskripsi</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($jabatans as $jabatan)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>
                        {{ $jabatan->bidang->nama }}
                    </td>

                    <td class="fw-semibold">
                        {{ $jabatan->nama }}
                    </td>

                    <td>
                        {{ $jabatan->deskripsi ?? '-' }}
                    </td>

                    <td>

                        <a href="{{ route('admin.jabatan.edit',$jabatan) }}"
                            class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <form action="{{ route('admin.jabatan.destroy',$jabatan) }}"
                            method="POST"
                            class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">

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

                    <td colspan="5" class="text-center py-4 text-muted">
                        Belum ada data jabatan.
                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection