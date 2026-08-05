@extends('layouts.app')

@section('title', 'Honorarium Saya')
@section('page-title', 'Honorarium Saya')

@section('content')
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
        @forelse($honorarium as $h)
            <div
                class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-1 hover:shadow-lg
                dark:bg-slate-900 dark:ring-slate-700">

                <!-- Header -->
                <div
                    class="flex items-center justify-between border-b border-gray-200 px-6 py-4
                    dark:border-slate-700">
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                        {{ $h->namaBulan() }} {{ $h->tahun }}
                    </h3>

                    @php
                        $statusClass =
                            $h->status == 'final'
                                ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400';
                    @endphp

                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                        {{ ucfirst($h->status) }}
                    </span>
                </div>

                <!-- Body -->
                <div class="p-6">

                    <!-- Gaji Bersih -->
                    <div class="mb-6 text-center">
                        <p class="text-sm text-gray-500 dark:text-slate-400">
                            Gaji Bersih
                        </p>

                        <h2 class="mt-1 text-3xl font-bold text-green-600 dark:text-green-400">
                            Rp {{ number_format($h->gaji_bersih, 0, ',', '.') }}
                        </h2>
                    </div>

                    <!-- Statistik -->
                    <div class="mb-6 grid grid-cols-4 gap-3 text-center">

                        <div class="rounded-lg bg-green-50 p-3 dark:bg-green-900/30">
                            <p class="text-xs text-gray-500 dark:text-slate-400">Hadir</p>
                            <p class="mt-1 text-lg font-bold text-green-600 dark:text-green-400">
                                {{ $h->total_hadir }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-sky-50 p-3 dark:bg-sky-900/30">
                            <p class="text-xs text-gray-500 dark:text-slate-400">Izin</p>
                            <p class="mt-1 text-lg font-bold text-sky-600 dark:text-sky-400">
                                {{ $h->total_izin }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-yellow-50 p-3 dark:bg-yellow-900/30">
                            <p class="text-xs text-gray-500 dark:text-slate-400">Sakit</p>
                            <p class="mt-1 text-lg font-bold text-yellow-600 dark:text-yellow-400">
                                {{ $h->total_sakit }}
                            </p>
                        </div>

                        <div class="rounded-lg bg-red-50 p-3 dark:bg-red-900/30">
                            <p class="text-xs text-gray-500 dark:text-slate-400">Alpha</p>
                            <p class="mt-1 text-lg font-bold text-red-600 dark:text-red-400">
                                {{ $h->total_alpha }}
                            </p>
                        </div>

                    </div>

                    <!-- Detail -->
                    <div class="space-y-3 border-t border-gray-200 pt-4 text-sm dark:border-slate-700">

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-slate-400">
                                Gaji Pokok
                            </span>

                            <span class="font-medium text-gray-800 dark:text-slate-200">
                                Rp {{ number_format($h->gaji_pokok, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-slate-400">
                                Tunjangan
                            </span>

                            <span class="font-semibold text-green-600 dark:text-green-400">
                                + Rp {{ number_format($h->tunjangan, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 dark:text-slate-400">
                                Potongan
                            </span>

                            <span class="font-semibold text-red-600 dark:text-red-400">
                                - Rp {{ number_format($h->total_potongan, 0, ',', '.') }}
                            </span>
                        </div>

                    </div>

                </div>
            </div>

        @empty

            <div class="col-span-full">
                <div
                    class="rounded-xl bg-white p-12 text-center shadow-sm ring-1 ring-gray-200
                    dark:bg-slate-900 dark:ring-slate-700">
                    <i class="bi bi-wallet2 mb-4 block text-6xl text-gray-300 dark:text-slate-600"></i>

                    <p class="text-lg font-medium text-gray-500 dark:text-slate-400">
                        Belum ada data honorarium.
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    @if ($honorarium->hasPages())
        <div class="mt-6">
            {{ $honorarium->links() }}
        </div>
    @endif
@endsection
