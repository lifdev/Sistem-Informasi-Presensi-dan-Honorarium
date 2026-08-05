@extends('layouts.app')

@section('title', 'Pengaturan Jam Kerja')

@section('content')

    <div class="mx-auto max-w-6xl">

        <div class="mb-6">

            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Pengaturan Jam Kerja
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Atur waktu presensi masuk dan pulang yang berlaku untuk seluruh karyawan.
            </p>

        </div>

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
                            Tentukan rentang waktu presensi masuk dan pulang.
                        </p>

                    </div>

                    <div class="space-y-8 p-6">

                        <div
                            class="rounded-2xl border border-green-200 bg-green-50 p-6 dark:border-green-900 dark:bg-green-950/20">

                            <div class="mb-5 flex items-center gap-3">

                                <div class="rounded-xl bg-green-100 p-3 text-green-600 dark:bg-green-900/30">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

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

                                    <label class="mb-2 block text-sm font-medium">
                                        Mulai
                                    </label>

                                    <input type="time" name="jam_masuk_mulai"
                                        value="{{ old('jam_masuk_mulai', $jam->jam_masuk_mulai ?? '07:00') }}"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                                    @error('jam_masuk_mulai')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror

                                </div>

                                <div>

                                    <label class="mb-2 block text-sm font-medium">
                                        Selesai
                                    </label>

                                    <input type="time" name="jam_masuk_selesai"
                                        value="{{ old('jam_masuk_selesai', $jam->jam_masuk_selesai ?? '09:00') }}"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                                    @error('jam_masuk_selesai')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        <div
                            class="rounded-2xl border border-amber-200 bg-amber-50 p-6 dark:border-amber-900 dark:bg-amber-950/20">

                            <div class="mb-5 flex items-center gap-3">

                                <div class="rounded-xl bg-amber-100 p-3 text-amber-600 dark:bg-amber-900/30">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7 16l-4-4m0 0l4-4m-4 4h18" />

                                    </svg>

                                </div>

                                <div>

                                    <h3 class="font-semibold text-amber-700 dark:text-amber-400">
                                        Jam Absen Pulang
                                    </h3>

                                    <p class="text-sm text-amber-600 dark:text-amber-500">
                                        Rentang waktu presensi pulang.
                                    </p>

                                </div>

                            </div>

                            <div class="grid gap-5 md:grid-cols-2">

                                <div>

                                    <label class="mb-2 block text-sm font-medium">
                                        Mulai
                                    </label>

                                    <input type="time" name="jam_pulang_mulai"
                                        value="{{ old('jam_pulang_mulai', $jam->jam_pulang_mulai ?? '16:00') }}"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                                    @error('jam_pulang_mulai')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror

                                </div>

                                <div>

                                    <label class="mb-2 block text-sm font-medium">
                                        Selesai
                                    </label>

                                    <input type="time" name="jam_pulang_selesai"
                                        value="{{ old('jam_pulang_selesai', $jam->jam_pulang_selesai ?? '20:00') }}"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                                    @error('jam_pulang_selesai')
                                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                                    @enderror

                                </div>

                            </div>

                        </div>

                        <div
                            class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/20">

                            <p class="text-sm text-blue-700 dark:text-blue-300">

                                Presensi hanya dapat dilakukan sesuai rentang waktu yang ditentukan.
                                Di luar jam tersebut sistem otomatis menolak presensi.

                            </p>

                        </div>

                        <div class="flex justify-end">

                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

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

                                {{ \Carbon\Carbon::parse($jam->jam_masuk_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($jam->jam_masuk_selesai)->format('H:i') }}

                            </div>

                        </div>

                        <div class="rounded-xl bg-amber-50 p-5 text-center dark:bg-amber-950/20">

                            <div class="text-sm text-slate-500">
                                Absen Pulang
                            </div>

                            <div class="mt-2 text-2xl font-bold text-amber-600">

                                {{ \Carbon\Carbon::parse($jam->jam_pulang_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($jam->jam_pulang_selesai)->format('H:i') }}

                            </div>

                        </div>

                        <div
                            class="rounded-xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-800">

                            <p class="text-sm text-slate-600 dark:text-slate-400">

                                Pastikan jam masuk lebih awal daripada jam pulang agar proses presensi berjalan normal.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
