@extends('layouts.app')

@section('title', 'Pengaturan Gaji')
@section('page-title', 'Pengaturan Gaji')

@section('content')
<div class="card">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-sliders text-primary me-2"></i>Pengaturan Gaji Per Jabatan
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Jabatan</th>
                        <th class="text-end">Gaji Pokok</th>
                        <th class="text-end">Tunjangan Hadir/hari</th>
                        <th class="text-end">Potongan Alpha/hari</th>
                        <th class="text-end">Potongan Izin/hari</th>
                        <th class="text-end">Potongan Sakit/hari</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td class="fw-semibold">{{ $item->jabatan }}</td>
                        <td class="text-end">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="text-end text-success">Rp {{ number_format($item->tunjangan_hadir, 0, ',', '.') }}</td>
                        <td class="text-end text-danger">Rp {{ number_format($item->potongan_alpha, 0, ',', '.') }}</td>
                        <td class="text-end text-warning">Rp {{ number_format($item->potongan_izin, 0, ',', '.') }}</td>
                        <td class="text-end text-warning">Rp {{ number_format($item->potongan_sakit, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <button class="btn btn-outline-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalGaji{{ $item->id }}">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                        </td>
                    </tr>

                    {{-- Modal Edit Gaji --}}
                    <div class="modal fade" id="modalGaji{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">
                                        Edit Gaji — {{ $item->jabatan }}
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.pengaturan.gaji.update', $item) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Gaji Pokok</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="gaji_pokok"
                                                    class="form-control"
                                                    value="{{ $item->gaji_pokok }}"
                                                    min="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Tunjangan Kehadiran / hari</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="tunjangan_hadir"
                                                    class="form-control"
                                                    value="{{ $item->tunjangan_hadir }}"
                                                    min="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Potongan Alpha / hari</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="potongan_alpha"
                                                    class="form-control"
                                                    value="{{ $item->potongan_alpha }}"
                                                    min="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Potongan Izin / hari</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="potongan_izin"
                                                    class="form-control"
                                                    value="{{ $item->potongan_izin }}"
                                                    min="0" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Potongan Sakit / hari</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="potongan_sakit"
                                                    class="form-control"
                                                    value="{{ $item->potongan_sakit }}"
                                                    min="0" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-save me-1"></i>Simpan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- End Modal --}}

                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-sliders fs-3 d-block mb-2"></i>
                            Belum ada data pengaturan gaji.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection