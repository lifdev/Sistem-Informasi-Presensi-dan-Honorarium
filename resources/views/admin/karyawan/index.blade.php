@extends('layouts.app')

@section('title', 'Data Karyawan')
@section('page-title', 'Data Karyawan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <span class="fw-semibold"><i class="bi bi-people text-primary me-2"></i>Daftar Karyawan</span>
        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus me-1"></i>Tambah Karyawan
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Bidang</th>
                        <th>Jabatan</th>
                        <th>No. HP</th>
                        <th>Tgl Masuk</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawan as $k)
                    <tr>
                        <td class="fw-semibold text-muted small">{{ $k->nip }}</td>
                        <td>
                            <div class="fw-semibold">{{ $k->nama }}</div>
                            <div class="text-muted small">{{ $k->user->email ?? '-' }}</div>
                        </td>
                        <td>{{ $k->jabatan?->bidang?->nama ?? '-' }}</td>
                        <td>{{ $k->jabatan?->nama ?? '-' }}</td>
                        <td>{{ $k->no_hp ?? '-' }}</td>
                        <td>{{ $k->tanggal_masuk->format('d/m/Y') }}</td>
                        <td>
                            @php
                                $roleColor = match($k->user->role ?? '') {
                                    'admin'    => 'primary',
                                    'pimpinan' => 'purple',
                                    default    => 'secondary'
                                };
                            @endphp
                            <span class="badge bg-{{ $roleColor }}">
                                {{ ucfirst($k->user->role ?? '-') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ $k->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($k->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.karyawan.edit', $k) }}"
                               class="btn btn-outline-warning btn-sm">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.karyawan.destroy', $k) }}"
                                  method="POST" class="d-inline"
                                  onsubmit="return confirm('Hapus karyawan {{ $k->nama }}? Akun login juga akan dihapus.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            <i class="bi bi-people fs-3 d-block mb-2"></i>
                            Belum ada data karyawan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($karyawan->hasPages())
    <div class="card-footer bg-white">
        {{ $karyawan->links() }}
    </div>
    @endif
</div>
@endsection
