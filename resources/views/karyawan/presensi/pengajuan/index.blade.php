@extends('layouts.app')

@section('title', 'Pengajuan Presensi Susulan')
@section('page-title', 'Pengajuan Presensi Susulan')

@section('content')
<div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-slate-900 dark:ring-slate-700">

    <!-- Header -->
    <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-slate-700">
        <h2 class="flex items-center text-lg font-semibold text-gray-800 dark:text-white">
            <i class="bi bi-calendar-week mr-2 text-blue-600 dark:text-blue-400"></i>
            Riwayat Pengajuan Presensi Susulan
        </h2>

        <a href="{{ route('karyawan.presensi.pengajuan.create') }}"
            class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500">
            <i class="bi bi-plus-lg mr-2"></i>
            Ajukan Presensi
        </a>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-slate-50 dark:bg-slate-800">
                <tr>
                    <th class="px-4 py-3 pl-6 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">Tanggal</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">Jam Masuk</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">Alasan</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600 dark:text-slate-300">Status</th>
                </tr>
            </thead>

            <tbody
                class="divide-y divide-gray-100 bg-white text-sm text-gray-700 dark:divide-slate-700 dark:bg-slate-900 dark:text-slate-300">
                @forelse($pengajuan as $p)
                <tr class="transition hover:bg-gray-50 dark:hover:bg-slate-800">
                    <td class="px-6 py-4">
                        {{ $p->tanggal->format('d/m/Y') }}
                    </td>

                    <td class="px-6 py-4">
                        {{ \Illuminate\Support\Carbon::parse($p->jam_masuk)->format('H:i') }}
                    </td>

                    <td class="max-w-xs truncate px-6 py-4" title="{{ $p->alasan }}">
                        {{ $p->alasan }}
                    </td>

                    <td class="px-6 py-4">
                        @php
                        $statusClass = match ($p->status) {
                        'disetujui'
                        => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                        'ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                        default
                        => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                        };
                        @endphp

                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                        <i class="bi bi-calendar-x mb-3 block text-4xl text-gray-400 dark:text-slate-600"></i>
                        Belum ada pengajuan presensi susulan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($pengajuan->hasPages())
    <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 dark:border-slate-700 dark:bg-slate-800">
        {{ $pengajuan->links() }}
    </div>
    @endif
</div>
@endsection