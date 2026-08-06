@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('content')

<div class="mx-auto max-w-7xl space-y-8">

    {{-- Card --}}
    <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Karyawan --}}
        <x-card class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Total Karyawan
                    </p>
                    <h2 class="mt-2 text-3xl font-bold">
                        {{ $totalKaryawan }}
                    </h2>
                </div>
                <div class="rounded-xl bg-blue-100 p-3 text-blue-600 dark:bg-blue-900/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                    </svg>
                </div>
            </div>
        </x-card>

        {{-- Hadir Hari Ini --}}
        <x-card class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Hadir Hari Ini
                    </p>
                    <h2 class="mt-2 text-3xl font-bold">
                        {{ $hadirHariIni }}
                    </h2>
                </div>

                <div class="rounded-xl bg-green-100 p-3 text-green-600 dark:bg-green-900/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>
                </div>
            </div>
        </x-card>

        {{-- Izin Pending --}}
        <x-card class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Izin Pending
                    </p>
                    <h2 class="mt-2 text-3xl font-bold">
                        {{ $totalIzinPending }}
                    </h2>
                </div>

                <div class="rounded-xl bg-yellow-100 p-3 text-yellow-600 dark:bg-yellow-900/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 3h8l3 3v15H5V6l3-3z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v5" />
                        <circle cx="12" cy="16" r="1" />
                    </svg>
                </div>
            </div>
        </x-card>

        {{-- Honorarium --}}
        <x-card class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Honorarium Draft
                    </p>
                    <h2 class="mt-2 text-3xl font-bold">
                        {{ $honorariumDraft }}
                    </h2>
                </div>

                <div class="rounded-xl bg-purple-100 p-3 text-purple-600 dark:bg-purple-900/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                        <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                    </svg>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Tabel --}}
    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="flex items-center justify-between border-b border-slate-200 p-6 dark:border-slate-800">

            <div>

                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Izin Menunggu Persetujuan
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Daftar pengajuan izin yang membutuhkan persetujuan.
                </p>

            </div>

            <a href="{{ route('pimpinan.izin.approval') }}"
                class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                Lihat Semua

            </a>

        </div>

        @if ($izinPending->isEmpty())

        <div class="py-16 text-center">

            <div
                class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-100 dark:bg-slate-800">

                <i class="bi bi-check-all text-4xl text-slate-400"></i>

            </div>

            <h3 class="text-lg font-semibold text-slate-700 dark:text-white">
                Tidak ada pengajuan izin
            </h3>

            <p class="mt-2 text-sm text-slate-500">
                Semua pengajuan izin telah diproses.
            </p>

        </div>
        @else
        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">
                            Karyawan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">
                            Jenis
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">
                            Alasan
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold text-slate-600 dark:text-slate-300">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @foreach ($izinPending as $izin)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">

                        <td class="px-6 py-4 font-medium text-slate-800 dark:text-white">
                            {{ $izin->karyawan->nama }}
                        </td>

                        <td class="px-6 py-4">

                            @if ($izin->jenis == 'sakit')
                            <span
                                class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                Sakit
                            </span>
                            @else
                            <span
                                class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">
                                {{ ucfirst($izin->jenis) }}
                            </span>
                            @endif

                        </td>

                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">

                            {{ $izin->tanggal_mulai->format('d/m/Y') }}

                            -

                            {{ $izin->tanggal_selesai->format('d/m/Y') }}

                        </td>

                        <td class="max-w-xs truncate px-6 py-4 text-slate-600 dark:text-slate-300">
                            {{ $izin->alasan }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                <form action="{{ route('pimpinan.izin.approve', $izin) }}" method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        onclick="return confirm('Setujui izin ini?')"
                                        class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">

                                        Setujui

                                    </button>

                                </form>

                                <form action="{{ route('pimpinan.izin.reject', $izin) }}" method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button
                                        onclick="return confirm('Tolak izin ini?')"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">

                                        Tolak

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

        @endif

    </div>

</div>

@endsection