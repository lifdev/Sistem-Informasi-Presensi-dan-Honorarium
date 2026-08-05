@extends('layouts.app')

@section('title', 'Ajukan Izin')
@section('page-title', 'Ajukan Izin')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-3xl">
        <div
            class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-slate-900 dark:ring-slate-700">
            <!-- Header -->
            <div class="border-b border-gray-200 px-6 py-4 dark:border-slate-700">
                <h2 class="flex items-center text-lg font-semibold text-gray-800 dark:text-white">
                    <i class="bi bi-file-earmark-plus mr-2 text-blue-600 dark:text-blue-400"></i>
                    Form Pengajuan Izin
                </h2>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form action="{{ route('karyawan.izin.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Jenis -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Jenis Izin <span class="text-red-500">*</span>
                        </label>

                        <select name="jenis"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('jenis') border-red-500 @enderror"
                            required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="izin" {{ old('jenis') == 'izin' ? 'selected' : '' }}>Izin</option>
                            <option value="sakit" {{ old('jenis') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        </select>

                        @error('jenis')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-5 grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Tanggal Mulai <span class="text-red-500">*</span>
                            </label>

                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                min="{{ date('Y-m-d') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('tanggal_mulai') border-red-500 @enderror">

                            @error('tanggal_mulai')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Tanggal Selesai <span class="text-red-500">*</span>
                            </label>

                            <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                                min="{{ date('Y-m-d') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('tanggal_selesai') border-red-500 @enderror">

                            @error('tanggal_selesai')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Durasi -->
                    <div id="durasi-info"
                        class="mb-5 hidden rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-300">
                        <i class="bi bi-info-circle mr-1"></i>
                        Durasi:
                        <strong id="durasi-hari">0</strong>
                        hari
                    </div>

                    <!-- Alasan -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Alasan <span class="text-red-500">*</span>
                        </label>

                        <textarea name="alasan" rows="4" placeholder="Tuliskan alasan izin..." required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder:text-slate-400 @error('alasan') border-red-500 @enderror">{{ old('alasan') }}</textarea>

                        @error('alasan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lampiran -->
                    <div class="mb-6">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Lampiran
                            <span class="text-xs font-normal text-gray-500 dark:text-slate-400">(opsional)</span>
                        </label>

                        <input type="file" name="lampiran" accept=".pdf,.jpg,.jpeg,.png"
                            class="block w-full rounded-lg border border-gray-300 bg-white text-sm text-gray-700 file:mr-4 file:rounded-md file:border-0 file:bg-blue-600 file:px-4 file:py-2 file:text-white hover:file:bg-blue-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 @error('lampiran') border-red-500 @enderror">

                        <p class="mt-2 text-sm text-gray-500 dark:text-slate-400">
                            Format: PDF, JPG, PNG. Maksimal 2MB. (Surat dokter, dsb.)
                        </p>

                        @error('lampiran')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="flex flex-wrap gap-3">
                        <button type="submit"
                            class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500">
                            <i class="bi bi-send mr-2"></i>
                            Kirim Pengajuan
                        </button>

                        <a href="{{ route('karyawan.izin.index') }}"
                            class="inline-flex items-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const tglMulai = document.querySelector('[name="tanggal_mulai"]');
    const tglSelesai = document.querySelector('[name="tanggal_selesai"]');
    const durasiInfo = document.getElementById('durasi-info');
    const durasiHari = document.getElementById('durasi-hari');

    function hitungDurasi() {
        if (tglMulai.value && tglSelesai.value) {
            const start = new Date(tglMulai.value);
            const end = new Date(tglSelesai.value);
            const diff = Math.round((end - start) / (1000 * 60 * 60 * 24)) + 1;

            if (diff > 0) {
                durasiHari.textContent = diff;
                durasiInfo.classList.remove('hidden');
            } else {
                durasiInfo.classList.add('hidden');
            }
        } else {
            durasiInfo.classList.add('hidden');
        }
    }

    tglMulai.addEventListener('change', () => {
        tglSelesai.min = tglMulai.value;
        hitungDurasi();
    });

    tglSelesai.addEventListener('change', hitungDurasi);
</script>
@endpush