@extends('layouts.app')

@section('title', 'Riwayat Presensi')
@section('page-title', 'Riwayat Presensi')

@section('content')
<div class="w-full">

    {{-- Header --}}
    <div
        class="mb-4 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="p-6">
            <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="flex items-center">
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-slate-800 dark:text-white">
                            Riwayat Presensi
                        </h3>
                        <span class="text-slate-500 dark:text-slate-400">
                            Lihat seluruh aktivitas presensi berdasarkan periode.
                        </span>
                    </div>
                </div>

                <div class="lg:w-auto">
                    <form method="GET" class="flex flex-wrap gap-2">
                        <select name="bulan"
                            class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}
                            </option>
                            @endforeach
                        </select>

                        <select name="tahun"
                            class="rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700 focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300">
                            @foreach (range(date('Y') - 2, date('Y')) as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>
                                {{ $t }}
                            </option>
                            @endforeach
                        </select>

                        <button
                            class="flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2 text-white transition hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 dark:bg-slate-800">
                    <tr>
                        <th class="px-4 py-3 pl-6 text-sm font-semibold text-slate-600 dark:text-slate-300">Tanggal</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Masuk</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Status</th>
                        <th class="px-4 py-3 text-sm font-semibold text-slate-600 dark:text-slate-300">Keterangan</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($presensi as $p)
                    @php
                    $badge = match ($p->status) {
                    'hadir' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400',
                    'izin' => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-400',
                    'sakit' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                    'alpha' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                    default => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                    };
                    @endphp

                    <tr class="dark:hover:bg-slate-800/50">
                        <td class="px-4 py-3 pl-6">
                            <div class="font-semibold text-slate-800 dark:text-white">
                                {{ $p->tanggal->translatedFormat('d F Y') }}
                            </div>
                            <small class="text-slate-500 dark:text-slate-400">
                                {{ $p->tanggal->translatedFormat('l') }}
                            </small>
                        </td>

                        <td class="px-4 py-3">
                            @if ($p->jam_masuk)
                            <div class="flex items-center font-semibold text-green-600 dark:text-green-400">
                                <svg class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9l3 3m0 0l-3 3m3-3H3m6.75-9H18a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0118 21H9.75" />
                                </svg>
                                {{ $p->jam_masuk }}
                            </div>
                            @else
                            <span class="text-slate-400 dark:text-slate-500">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
                            <span class="rounded-full {{ $badge }} px-3 py-1 text-xs font-semibold">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-slate-600 dark:text-slate-400">
                            {{ $p->keterangan ?? '-' }}
                        </td>
                    </tr>

                    @empty

                    <tr>
                        <td colspan="4">
                            <div class="py-16 text-center">
                                <svg class="mx-auto mb-3 h-16 w-16 text-slate-300 dark:text-slate-600"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-6.75-3l-3 3m0-3l3 3" />
                                </svg>
                                <h5 class="text-lg font-bold text-slate-800 dark:text-white">
                                    Tidak Ada Data Presensi
                                </h5>

                                <p class="mb-0 text-slate-500 dark:text-slate-400">
                                    Data presensi untuk periode ini belum tersedia.
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($presensi->hasPages())
        <div class="border-t border-slate-200 bg-white px-6 py-4 dark:border-slate-700 dark:bg-slate-900">
            {{ $presensi->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

@endsection