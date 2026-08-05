@extends('layouts.app')

@section('title', 'Honorarium')

@section('content')

    <div class="space-y-6">

        <div>

            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Manajemen Honorarium
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Generate dan kelola honorarium seluruh karyawan.
            </p>

        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Generate Honorarium
                </h2>

            </div>

            <form action="{{ route('admin.honorarium.generate') }}" method="POST" class="grid gap-5 p-6 md:grid-cols-3">

                @csrf

                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Bulan
                    </label>

                    <select name="bulan"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                        @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>

                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div>

                    <label class="mb-2 block text-sm font-medium">
                        Tahun
                    </label>

                    <select name="tahun"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                        @foreach (range(date('Y') - 2, date('Y')) as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>

                                {{ $t }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <div class="flex items-end">

                    <button onclick="return confirm('Generate honorarium untuk semua karyawan aktif?')"
                        class="w-full rounded-xl bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700">

                        Generate Honorarium

                    </button>

                </div>

            </form>

        </div>

        <div
            class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div
                class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 p-6 dark:border-slate-800">

                <div>

                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">

                        Honorarium —
                        {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
                        {{ $tahun }}

                    </h2>

                </div>

                <div class="flex flex-wrap gap-2">

                    @if ($honorarium->isNotEmpty())
                        <form action="{{ route('admin.honorarium.finalize') }}" method="POST">

                            @csrf

                            <input type="hidden" name="bulan" value="{{ $bulan }}">
                            <input type="hidden" name="tahun" value="{{ $tahun }}">

                            <button onclick="return confirm('Finalisasi honorarium bulan ini?')"
                                class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">

                                Finalisasi

                            </button>

                        </form>

                        <a href="{{ route('admin.laporan.honorarium.excel', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                            class="rounded-xl bg-green-600 px-4 py-2 text-sm font-medium text-white hover:bg-green-700">

                            Excel

                        </a>

                        <a href="{{ route('admin.laporan.honorarium.pdf', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                            class="rounded-xl bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">

                            PDF

                        </a>
                    @endif

                </div>

            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-100 dark:bg-slate-800">

                        <tr>

                            <th class="px-6 py-4 text-left text-sm font-semibold">Karyawan</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Hadir</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Izin</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Sakit</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Alpha</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Gaji Pokok</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Tunjangan</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Potongan</th>
                            <th class="px-6 py-4 text-right text-sm font-semibold">Gaji Bersih</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Status</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                        @forelse($honorarium as $h)
                            <tr class="hover:bg-slate-50 transition dark:hover:bg-slate-800/50">

                                <td class="px-6 py-4">

                                    <div class="font-medium text-slate-800 dark:text-white">
                                        {{ $h->karyawan->nama }}
                                    </div>

                                    <div class="text-sm text-slate-500 dark:text-slate-400">
                                        {{ $h->karyawan->jabatan?->bidang?->nama }}
                                        •
                                        {{ $h->karyawan->jabatan?->nama }}
                                    </div>

                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        {{ $h->total_hadir }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700 dark:bg-sky-900/30 dark:text-sky-300">
                                        {{ $h->total_izin }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                                        {{ $h->total_sakit }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                        {{ $h->total_alpha }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-right">
                                    Rp {{ number_format($h->gaji_pokok, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-right font-medium text-emerald-600">
                                    + Rp {{ number_format($h->tunjangan, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-right font-medium text-red-600">
                                    - Rp {{ number_format($h->total_potongan, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-slate-800 dark:text-white">
                                    Rp {{ number_format($h->gaji_bersih, 0, ',', '.') }}
                                </td>

                                <td class="px-6 py-4 text-center">

                                    @if ($h->status == 'final')
                                        <span
                                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                            Final
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                                            Draft
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.honorarium.show', $h) }}"
                                            class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                                            Detail

                                        </a>

                                        <a href="{{ route('admin.laporan.slip', $h) }}" target="_blank"
                                            class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">

                                            Slip

                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="11" class="px-6 py-12 text-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8c-3.314 0-6 2.239-6 5s2.686 5 6 5 6-2.239 6-5-2.686-5-6-5zm0-5v3m0 12v3m9-9h-3M6 12H3" />

                                    </svg>

                                    <p class="text-slate-500 dark:text-slate-400">
                                        Belum ada data honorarium. Klik <strong>Generate Honorarium</strong>.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                    @if ($honorarium->isNotEmpty())
                        <tfoot class="border-t bg-slate-50 dark:border-slate-700 dark:bg-slate-800">

                            <tr>

                                <td colspan="8" class="px-6 py-4 text-right font-semibold">
                                    Total Pengeluaran
                                </td>

                                <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                    Rp {{ number_format($honorarium->sum('gaji_bersih'), 0, ',', '.') }}
                                </td>

                                <td colspan="2"></td>

                            </tr>

                        </tfoot>
                    @endif

                </table>

            </div>

            @if ($honorarium->hasPages())
                <div class="border-t border-slate-200 p-6 dark:border-slate-800">

                    {{ $honorarium->appends(request()->query())->links() }}

                </div>
            @endif

        </div>

    </div>

@endsection
