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

{{-- Grafik Section --}}
<div class="mt-6 grid gap-6 xl:grid-cols-3">

    {{-- Tren Kehadiran --}}
    <x-card class="p-6 xl:col-span-2">
        <div class="mb-5 flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                Tren Kehadiran
            </h2>
            <select
                onchange="window.location.href = window.location.pathname + '?periode=' + this.value"
                class="rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-sm text-slate-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                <option value="7hari" {{ ($periode ?? '7hari') === '7hari' ? 'selected' : '' }}>
                    7 Hari Terakhir
                </option>
                <option value="bulan_ini" {{ ($periode ?? '') === 'bulan_ini' ? 'selected' : '' }}>
                    Bulan Ini
                </option>
                <option value="bulan_lalu" {{ ($periode ?? '') === 'bulan_lalu' ? 'selected' : '' }}>
                    Bulan Lalu
                </option>
            </select>
        </div>
        <div class="relative h-72">
            <canvas id="chartTrenKehadiran"></canvas>
        </div>
    </x-card>

    {{-- Komposisi Status Hari Ini --}}
    <x-card class="p-6">
        <h2 class="mb-5 text-lg font-semibold">
            Status Hari Ini
        </h2>
        <div class="relative h-72">
            <canvas id="chartStatusHariIni"></canvas>
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

    {{-- Presensi Saya + Informasi Sistem --}}
    <div class="grid gap-6">

        {{-- Presensi Saya --}}
        <x-card class="p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-lg font-semibold">
                    Presensi Saya
                </h2>
                <span class="text-xs text-slate-400">
                    {{ now()->translatedFormat('d F Y') }}
                </span>
            </div>

            @if ($presensiSaya)
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Status</p>
                    <span class="mt-1 inline-block rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-700 dark:bg-green-900/30 dark:text-green-400">
                        Sudah Absen
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">Jam Masuk</p>
                    <p class="mt-1 text-lg font-semibold">
                        {{ \Carbon\Carbon::parse($presensiSaya->jam_masuk)->format('H:i') }}
                    </p>
                </div>
            </div>
            @else
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">Status</p>
                    <span class="mt-1 inline-block rounded-full bg-yellow-100 px-3 py-1 text-sm font-medium text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                        Belum Absen
                    </span>
                </div>
                <a href="{{ route('karyawan.presensi.index') }}"
                    class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                    Absen Sekarang
                </a>
            </div>
            @endif
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

<script>
    // Dibungkus DOMContentLoaded karena Chart.js sekarang dimuat lewat
    // bundle Vite (type="module" = deferred), jadi harus nunggu siap dulu
    // sebelum manggil window.Chart
    document.addEventListener('DOMContentLoaded', () => {
        // ==== Data dari controller (lihat catatan variabel di bawah) ====
        const trenLabels = @json($tanggalTren ?? []);
        const trenData = @json($jumlahHadirTren ?? []);

        const statusLabels = @json($statusLabels ?? []);
        const statusData = @json($statusData ?? []);

        // ==== Styling global biar nyatu sama tema dashboard ====
        Chart.defaults.font.family = "'Inter', ui-sans-serif, system-ui, sans-serif";
        Chart.defaults.font.size = 12;
        Chart.defaults.color = '#64748b'; // slate-500

        // ==== Chart 1: Tren Kehadiran (Line, dengan gradient fill) ====
        const ctxTren = document.getElementById('chartTrenKehadiran');
        if (ctxTren) {
            const gradient = ctxTren.getContext('2d').createLinearGradient(0, 0, 0, 260);
            gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
            gradient.addColorStop(1, 'rgba(37, 99, 235, 0)');

            new Chart(ctxTren, {
                type: 'line',
                data: {
                    labels: trenLabels,
                    datasets: [{
                        label: 'Jumlah Hadir',
                        data: trenData,
                        borderColor: '#2563eb',
                        backgroundColor: gradient,
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#2563eb',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                label: (ctx) => `${ctx.parsed.y} orang hadir`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            border: {
                                display: false
                            },
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            },
                            border: {
                                display: false
                            },
                            ticks: {
                                precision: 0,
                                padding: 8
                            }
                        }
                    }
                }
            });
        }

        // ==== Chart 2: Komposisi Status Hari Ini (Doughnut + label total di tengah) ====
        const ctxStatus = document.getElementById('chartStatusHariIni');
        if (ctxStatus) {
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

                    ctx.font = '600 24px Inter, sans-serif';
                    ctx.fillStyle = '#1e293b';
                    ctx.fillText(totalStatus, x, y - 10);

                    ctx.font = '400 12px Inter, sans-serif';
                    ctx.fillStyle = '#94a3b8';
                    ctx.fillText('Karyawan', x, y + 14);

                    ctx.restore();
                }
            };

            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: [
                            '#22c55e', // Hadir - hijau
                            '#f59e0b', // Izin - amber
                            '#38bdf8', // Sakit - sky
                            '#cbd5e1', // Belum Absen - abu netral (bukan warning)
                        ],
                        borderWidth: 0,
                        spacing: 3,
                        borderRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '72%',
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
                                label: (ctx) => ` ${ctx.label}: ${ctx.parsed} orang`
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