@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('content')

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
                        {{ $izinPending }}
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

    {{-- Bottom Section --}}

    <div class="mt-6 grid gap-6 xl:grid-cols-2">

        {{-- Quick Action --}}
        <x-card class="p-6">
            <h2 class="mb-5 text-lg font-semibold">
                Aksi Cepat
            </h2>
            <div class="grid gap-3">
                <a href="{{ route('admin.karyawan.create') }}"
                    class="rounded-xl bg-blue-600 px-5 py-3 text-center font-medium text-white transition hover:bg-blue-700">
                    Tambah Karyawan
                </a>
                <a href="{{ route('admin.presensi.rekap') }}"
                    class="rounded-xl bg-green-600 px-5 py-3 text-center font-medium text-white transition hover:bg-green-700">
                    Rekap Presensi
                </a>
                <a href="{{ route('admin.izin.approval') }}"
                    class="flex items-center justify-center gap-2 rounded-xl bg-yellow-500 px-5 py-3 font-medium text-white transition hover:bg-yellow-600">
                    Approval Izin
                    @if ($izinPending > 0)
                        <span class="rounded-full bg-red-600 px-2 py-1 text-xs">
                            {{ $izinPending }}
                        </span>
                    @endif
                </a>
                <a href="{{ route('admin.honorarium.index') }}"
                    class="rounded-xl bg-purple-600 px-5 py-3 text-center font-medium text-white transition hover:bg-purple-700">
                    Generate Honorarium
                </a>
            </div>
        </x-card>

        {{-- Informasi Sistem --}}

        <x-card class="p-6">
            <h2 class="mb-5 text-lg font-semibold">
                Informasi Sistem
            </h2>
            <div class="space-y-4">
                <div class="flex justify-between">
                    <span class="text-slate-500">Tanggal</span>
                    <span>{{ now()->translatedFormat('l, d F Y') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Jam</span>
                    <span id="jam">{{ now()->format('H:i:s') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Login Sebagai</span>
                    <span>{{ auth()->user()->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-500">Role</span>
                    <span class="rounded-full bg-blue-600 px-3 py-1 text-sm text-white">
                        Admin
                    </span>
                </div>
            </div>
        </x-card>
    </div>

@endsection

@push('scripts')
    <script>
        setInterval(() => {
            const jam = new Date().toLocaleTimeString('id-ID');

            const jamDashboard = document.getElementById('jam');
            if (jamDashboard) jamDashboard.textContent = jam;
        }, 1000);
    </script>
@endpush
