@extends('layouts.app')

@section('title', 'Rekap Presensi')

@section('content')

<div class="space-y-6">

    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Rekap Presensi
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Rekap data presensi seluruh karyawan.
            </p>

        </div>

    </div>

    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div
            class="flex flex-col gap-4 border-b border-slate-200 p-6 dark:border-slate-800 lg:flex-row lg:items-center lg:justify-between">

            <form method="GET" class="flex flex-wrap items-center gap-3">

                <select name="bulan"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 dark:border-slate-700 dark:bg-slate-800">

                    @foreach (range(1, 12) as $b)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>

                        {{ DateTime::createFromFormat('!m', $b)->format('F') }}

                    </option>
                    @endforeach

                </select>

                <select name="tahun"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 dark:border-slate-700 dark:bg-slate-800">

                    @foreach (range(date('Y') - 2, date('Y')) as $t)
                    <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>

                        {{ $t }}

                    </option>
                    @endforeach

                </select>

                <button class="rounded-xl bg-blue-600 px-5 py-2.5 font-medium text-white hover:bg-blue-700">

                    Filter

                </button>

            </form>

            <div class="flex flex-wrap gap-3">

                <a href="{{ route('admin.laporan.presensi.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                    class="rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-emerald-700">

                    Export Excel

                </a>

                <a href="{{ route('admin.laporan.presensi.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                    class="rounded-xl bg-red-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-red-700">

                    Export PDF

                </a>

            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Foto
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Karyawan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Jam Masuk
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Keterangan
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse($presensi as $p)
                    <tr class="hover:bg-slate-50 transition dark:hover:bg-slate-800/50">

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $p->tanggal->translatedFormat('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            @if ($p->foto_masuk)
                            <a href="{{ $p->foto_masuk_url }}" target="_blank" rel="noopener">
                                <img src="{{ $p->foto_masuk_url }}" alt="Foto absen {{ $p->karyawan->nama }}"
                                    class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-200 dark:ring-slate-700">
                            </a>
                            @else
                            <span class="text-slate-400 dark:text-slate-500">-</span>
                            @endif
                        </td>

                        <td class="px-6 py-4">

                            <div class="font-medium text-slate-800 dark:text-white">
                                {{ $p->karyawan->nama }}
                            </div>

                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $p->karyawan->jabatan?->nama }}
                            </div>

                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $p->jam_masuk ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            @php
                            $badge = match ($p->status) {
                            'hadir'
                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                            'izin' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                            'sakit'
                            => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            'alpha' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                            default
                            => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                            };
                            @endphp

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $badge }}">
                                {{ ucfirst($p->status) }}
                            </span>

                        </td>

                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            @if ($p->keterangan === 'Terlambat')
                            <span class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                Terlambat
                            </span>
                            @elseif ($p->keterangan === 'Tepat Waktu')
                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                Tepat Waktu
                            </span>
                            @elseif ($p->keterangan === 'Hadir')
                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                Hadir
                            </span>
                            @else
                            {{ $p->keterangan ?? '-' }}
                            @endif
                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6" class="px-6 py-12 text-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m2 8H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2z" />

                            </svg>

                            <p class="text-slate-500 dark:text-slate-400">
                                Tidak ada data presensi untuk periode ini.
                            </p>

                        </td>

                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($presensi->hasPages())
        <div class="border-t border-slate-200 p-6 dark:border-slate-800">

            {{ $presensi->appends(request()->query())->links() }}

        </div>
        @endif

    </div>

</div>

@endsection