@extends('layouts.app')

@section('title', 'Pengaturan Jam Kerja')

@section('content')
<div class="mx-auto max-w-6xl">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            Pengaturan Jam Kerja
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Atur rentang waktu presensi masuk yang berlaku untuk seluruh karyawan.
        </p>
    </div>

    @if (session('success'))
    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-400">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-3">

        <div class="lg:col-span-2">
            <form action="{{ route('admin.pengaturan.jam.update') }}" method="POST"
                class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                @csrf
                @method('PUT')

                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                        Pengaturan Jam Presensi
                    </h2>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Tentukan rentang waktu presensi masuk.
                    </p>
                </div>

                <div class="space-y-8 p-6">

                    <div class="rounded-2xl border border-green-200 bg-green-50 p-6 dark:border-green-900 dark:bg-green-950/20">
                        <div class="mb-5 flex items-center gap-3">
                            <div class="rounded-xl bg-green-100 p-3 text-green-600 dark:bg-green-900/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-green-700 dark:text-green-400">
                                    Jam Absen Masuk
                                </h3>
                                <p class="text-sm text-green-600 dark:text-green-500">
                                    Rentang waktu presensi masuk.
                                </p>
                            </div>
                        </div>

                        <div class="grid gap-5 md:grid-cols-2">
                            <div>
                                <label for="jam_masuk_mulai" class="mb-2 block text-sm font-medium">
                                    Mulai
                                </label>
                                <input
                                    type="time"
                                    id="jam_masuk_mulai"
                                    name="jam_masuk_mulai"
                                    value="{{ old('jam_masuk_mulai', $jam->jam_masuk_mulai ?? '07:00') }}"
                                    class="w-full rounded-xl border px-4 py-3 dark:bg-slate-800
                                        {{ $errors->has('jam_masuk_mulai') ? 'border-red-400' : 'border-slate-300 dark:border-slate-700' }}">
                                @error('jam_masuk_mulai')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jam_masuk_selesai" class="mb-2 block text-sm font-medium">
                                    Selesai (batas akhir absen masuk)
                                </label>
                                <input
                                    type="time"
                                    id="jam_masuk_selesai"
                                    name="jam_masuk_selesai"
                                    value="{{ old('jam_masuk_selesai', $jam->jam_masuk_selesai ?? '09:00') }}"
                                    class="w-full rounded-xl border px-4 py-3 dark:bg-slate-800
                                        {{ $errors->has('jam_masuk_selesai') ? 'border-red-400' : 'border-slate-300 dark:border-slate-700' }}">
                                @error('jam_masuk_selesai')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/20">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            Presensi hanya dapat dilakukan sesuai rentang waktu yang ditentukan.
                            Di luar jam tersebut sistem otomatis menolak presensi.
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                            Simpan Pengaturan
                        </button>
                    </div>

                </div>
            </form>
        </div>

        <div>
            <div class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                        Jam Aktif
                    </h2>
                </div>

                <div class="space-y-5 p-6">
                    <div class="rounded-xl bg-green-50 p-5 text-center dark:bg-green-950/20">
                        <div class="text-sm text-slate-500">
                            Absen Masuk
                        </div>
                        <div class="mt-2 text-2xl font-bold text-green-600">
                            @if ($jam->jam_masuk_mulai && $jam->jam_masuk_selesai)
                            {{ \Carbon\Carbon::parse($jam->jam_masuk_mulai)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($jam->jam_masuk_selesai)->format('H:i') }}
                            @else
                            <span class="text-base font-medium text-slate-400">Belum diatur</span>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800">
                        <p class="text-sm text-slate-600 dark:text-slate-400">
                            Rentang ini berlaku untuk seluruh presensi masuk karyawan.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection