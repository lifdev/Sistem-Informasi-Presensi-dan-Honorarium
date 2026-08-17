@extends('layouts.app')

@section('title', 'Ajukan Presensi Susulan')
@section('page-title', 'Ajukan Presensi Susulan')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-3xl">
        <div
            class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-slate-900 dark:ring-slate-700">
            <!-- Header -->
            <div class="border-b border-gray-200 px-6 py-4 dark:border-slate-700">
                <h2 class="flex items-center text-lg font-semibold text-gray-800 dark:text-white">
                    <i class="bi bi-calendar-plus mr-2 text-blue-600 dark:text-blue-400"></i>
                    Form Pengajuan Presensi Susulan
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-slate-400">
                    Gunakan form ini jika Anda lupa melakukan absen masuk pada hari kerja tertentu.
                </p>
            </div>

            <!-- Body -->
            <div class="p-6">
                <form action="{{ route('karyawan.presensi.pengajuan.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Tanggal & Jam -->
                    <div class="mb-5 grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Tanggal <span class="text-red-500">*</span>
                            </label>

                            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                                max="{{ date('Y-m-d') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('tanggal') border-red-500 @enderror">

                            @error('tanggal')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Jam Masuk <span class="text-red-500">*</span>
                            </label>

                            <input type="time" name="jam_masuk" value="{{ old('jam_masuk') }}" required
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('jam_masuk') border-red-500 @enderror">

                            @error('jam_masuk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Alasan <span class="text-red-500">*</span>
                        </label>

                        <textarea name="alasan" rows="4" placeholder="Jelaskan alasan lupa absen..." required
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
                            Format: PDF, JPG, PNG. Maksimal 2MB. (Bukti pendukung, jika ada)
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

                        <a href="{{ route('karyawan.presensi.pengajuan.index') }}"
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