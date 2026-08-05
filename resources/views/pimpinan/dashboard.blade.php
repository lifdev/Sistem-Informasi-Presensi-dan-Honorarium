@extends('layouts.app')

@section('title', 'Dashboard Pimpinan')

@section('content')

    <div class="mx-auto max-w-7xl space-y-8">

        {{-- Card --}}
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">

            {{-- Hadir Bulan Ini --}}
            <x-card class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Hadir Bulan Ini
                        </p>
                        <h2 class="mt-2 text-3xl font-bold">
                            {{ $rekap['hadir'] ?? 0 }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-blue-100 p-3 text-blue-600 dark:bg-blue-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-circle-check">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                            <path d="M9 12l2 2l4 -4" />
                        </svg>
                    </div>
                </div>
            </x-card>

            {{-- Izin Bulan Ini --}}
            <x-card class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Izin Bulan Ini
                        </p>
                        <h2 class="mt-2 text-3xl font-bold">
                            {{ $rekap['izin'] ?? 0 }}
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

            {{-- Sakit Bulan Ini --}}
            <x-card class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Sakit Bulan Ini
                        </p>
                        <h2 class="mt-2 text-3xl font-bold">
                            {{ $rekap['sakit'] ?? 0 }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-red-100 p-3 text-yellow-600 dark:bg-yellow-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-report-medical">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                            <path d="M9 5a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2" />
                            <path d="M10 14l4 0" />
                            <path d="M12 12l0 4" />
                        </svg>
                    </div>
                </div>
            </x-card>

            {{-- Alpa Bulan Ini --}}
            <x-card class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Alpha Bulan Ini
                        </p>
                        <h2 class="mt-2 text-3xl font-bold">
                            {{ $rekap['alpha'] ?? 0 }}
                        </h2>
                    </div>
                    <div class="rounded-xl bg-yellow-100 p-3 text-yellow-600 dark:bg-yellow-900/30">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-alert-triangle">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 9v4" />
                            <path
                                d="M10.363 3.591l-8.106 13.534a1.914 1.914 0 0 0 1.636 2.871h16.214a1.914 1.914 0 0 0 1.636 -2.87l-8.106 -13.536a1.914 1.914 0 0 0 -3.274 0" />
                            <path d="M12 16h.01" />
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

                        <thead class="bg-slate-50 dark:bg-slate-800">

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

                                                <button onclick="return confirm('Setujui izin ini?')"
                                                    class="rounded-lg bg-green-600 px-3 py-2 text-white hover:bg-green-700">

                                                    <i class="bi bi-check-lg"></i>

                                                </button>

                                            </form>

                                            <form action="{{ route('pimpinan.izin.reject', $izin) }}" method="POST">

                                                @csrf
                                                @method('PATCH')

                                                <button onclick="return confirm('Tolak izin ini?')"
                                                    class="rounded-lg bg-red-600 px-3 py-2 text-white hover:bg-red-700">

                                                    <i class="bi bi-x-lg"></i>

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
