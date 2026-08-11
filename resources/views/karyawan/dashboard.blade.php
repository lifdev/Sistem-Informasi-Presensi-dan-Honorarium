@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

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
                        {{ $rekapBulanIni['hadir'] ?? 0 }}
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
                        {{ $rekapBulanIni['izin'] ?? 0 }}
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
                        {{ $rekapBulanIni['sakit'] ?? 0 }}
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
                        {{ $rekapBulanIni['alpha'] ?? 0 }}
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

    {{-- Komposisi Kehadiran --}}
    <x-card class="p-6">
        <h2 class="mb-5 text-lg font-semibold">
            Komposisi Kehadiran Bulan Ini
        </h2>
        <div class="relative h-64 sm:h-72">
            <canvas id="chartKomposisiBulanIni"></canvas>
        </div>
    </x-card>

    {{-- Content --}}
    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Presensi --}}
        <div
            class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Absen Hari Ini
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Status kehadiran Anda hari ini.
                </p>

            </div>

            <div class="p-6">

                @if ($presensiHariIni)

                <div class="mb-6 flex items-center gap-3">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">

                        <svg class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>

                    <div>

                        <h3 class="font-semibold text-slate-800 dark:text-white">
                            Sudah Absen Hari Ini
                        </h3>

                        <p class="text-sm text-slate-500">
                            Presensi berhasil direkam.
                        </p>

                    </div>

                </div>

                <div class="space-y-4">

                    <div class="flex justify-between border-b pb-3">
                        <span class="text-slate-500">Jam Masuk</span>
                        <span class="font-semibold">{{ $presensiHariIni->jam_masuk ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Status
                        </span>

                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                            {{ ucfirst($presensiHariIni->status) }}
                        </span>

                    </div>

                </div>

                @else
                <div class="py-8 text-center">

                    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-100">

                        <svg class="w-9 h-9 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2" />
                            <circle cx="12" cy="12" r="9" stroke-linecap="round" />
                        </svg>

                    </div>

                    <h3 class="font-semibold text-slate-800">
                        Belum Absen Hari Ini
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Silakan lakukan presensi terlebih dahulu.
                    </p>

                    <a href="{{ route('karyawan.presensi.index') }}"
                        class="mt-6 inline-flex items-center rounded-xl bg-blue-600 px-6 py-3 font-medium text-white hover:bg-blue-700">

                        <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.864 4.243A7.5 7.5 0 0119.5 10.5c0 2.92-.556 5.709-1.568 8.268M5.742 6.364A7.465 7.465 0 004.5 10.5a7.464 7.464 0 01-1.15 3.993m1.989 3.559A11.209 11.209 0 008.25 10.5a3.75 3.75 0 117.5 0c0 .527-.021 1.049-.064 1.565M12 10.5a14.94 14.94 0 01-3.6 9.75m6.633-4.596a18.666 18.666 0 01-2.485 5.33" />
                        </svg>

                        Absen Sekarang

                    </a>

                </div>

                @endif

            </div>

        </div>

        {{-- Honorarium --}}
        <div
            class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Honorarium Terakhir
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Informasi honorarium terakhir Anda.
                </p>

            </div>

            <div class="p-6">

                @if ($honorariumTerakhir)
                <div class="mb-6 text-center">

                    <p class="text-sm text-slate-500">
                        {{ $honorariumTerakhir->namaBulan() }}
                        {{ $honorariumTerakhir->tahun }}
                    </p>

                    <h2 class="mt-2 text-4xl font-bold text-green-600">

                        Rp {{ number_format($honorariumTerakhir->gaji_bersih, 0, ',', '.') }}

                    </h2>

                    <span
                        class="mt-3 inline-block rounded-full px-3 py-1 text-xs font-semibold
                            {{ $honorariumTerakhir->status == 'final' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">

                        {{ ucfirst($honorariumTerakhir->status) }}

                    </span>

                </div>

                <div class="space-y-4">

                    <div class="flex justify-between border-b pb-3">

                        <span class="text-slate-500">
                            Gaji Pokok
                        </span>

                        <span class="font-semibold">

                            Rp {{ number_format($honorariumTerakhir->gaji_pokok, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between border-b pb-3">

                        <span class="text-slate-500">
                            Bonus
                        </span>

                        <span class="font-semibold text-green-600">

                            + Rp {{ number_format($honorariumTerakhir->bonus, 0, ',', '.') }}

                        </span>

                    </div>

                    <div class="flex justify-between">

                        <span class="text-slate-500">
                            Potongan
                        </span>

                        <span class="font-semibold text-red-600">

                            - Rp {{ number_format($honorariumTerakhir->total_potongan, 0, ',', '.') }}

                        </span>

                    </div>

                </div>

                <a href="{{ route('karyawan.honorarium.index') }}"
                    class="mt-6 flex w-full items-center justify-center rounded-xl border border-green-600 px-4 py-3 font-medium text-green-600 transition hover:bg-green-50">

                    Lihat Semua Honorarium

                </a>
                @else
                <div class="py-8 text-center">

                    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-slate-100">

                        <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>

                    </div>

                    <h3 class="font-semibold text-slate-700">
                        Belum Ada Honorarium
                    </h3>

                    <p class="mt-2 text-sm text-slate-500">
                        Honorarium akan muncul setelah diproses.
                    </p>

                </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    setInterval(() => {
        const now = new Date();
    }, 1000);
</script>

@php
$statusDataKaryawan = [
$rekapBulanIni['hadir'] ?? 0,
$rekapBulanIni['izin'] ?? 0,
$rekapBulanIni['sakit'] ?? 0,
$rekapBulanIni['alpha'] ?? 0,
];
@endphp

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // ==== Data dari $rekapBulanIni yang sudah dikirim controller (tanpa query baru) ====
        const statusLabels = ['Hadir', 'Izin', 'Sakit', 'Alpha'];
        const statusData = @json($statusDataKaryawan);

        Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#64748b';

        const ctxKomposisi = document.getElementById('chartKomposisiBulanIni');
        if (ctxKomposisi) {
            const totalStatus = statusData.reduce((a, b) => a + b, 0);

            const centerTextPlugin = {
                id: 'centerText',
                beforeDraw(chart) {
                    const {
                        ctx,
                        chartArea: {
                            left,
                            right,
                            top,
                            bottom
                        }
                    } = chart;
                    const x = (left + right) / 2;
                    const y = (top + bottom) / 2;

                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    ctx.font = '600 22px Inter, sans-serif';
                    ctx.fillStyle = '#1e293b';
                    ctx.fillText(totalStatus, x, y - 10);

                    ctx.font = '400 12px Inter, sans-serif';
                    ctx.fillStyle = '#94a3b8';
                    ctx.fillText('Hari Tercatat', x, y + 14);

                    ctx.restore();
                }
            };

            new Chart(ctxKomposisi, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: [
                            '#22c55e', // Hadir - hijau
                            '#f59e0b', // Izin - amber
                            '#ef4444', // Sakit - merah
                            '#94a3b8', // Alpha - abu
                        ],
                        borderWidth: 0,
                        spacing: 3,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 8,
                                boxHeight: 8,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 16,
                            }
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            cornerRadius: 8,
                            callbacks: {
                                label: (ctx) => ` ${ctx.label}: ${ctx.parsed} hari`
                            }
                        }
                    }
                },
                plugins: [centerTextPlugin]
            });
        }
    });
</script>
@endpush