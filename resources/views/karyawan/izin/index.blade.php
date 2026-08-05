@extends('layouts.app')

@section('title', 'Izin Saya')
@section('page-title', 'Izin Saya')

@section('content')
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-slate-900 dark:ring-slate-700">

        <!-- Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4 dark:border-slate-700">
            <h2 class="flex items-center text-lg font-semibold text-gray-800 dark:text-white">
                <i class="bi bi-file-earmark-text mr-2 text-blue-600 dark:text-blue-400"></i>
                Riwayat Pengajuan Izin
            </h2>

            <a href="{{ route('karyawan.izin.create') }}"
                class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500">
                <i class="bi bi-plus-lg mr-2"></i>
                Ajukan Izin
            </a>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-800">
                    <tr class="text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-slate-300">
                        <th class="px-6 py-3">Jenis</th>
                        <th class="px-6 py-3">Tanggal Mulai</th>
                        <th class="px-6 py-3">Tanggal Selesai</th>
                        <th class="px-6 py-3">Durasi</th>
                        <th class="px-6 py-3">Alasan</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>

                <tbody
                    class="divide-y divide-gray-100 bg-white text-sm text-gray-700 dark:divide-slate-700 dark:bg-slate-900 dark:text-slate-300">
                    @forelse($izin as $i)
                        <tr class="transition hover:bg-gray-50 dark:hover:bg-slate-800">
                            <td class="px-6 py-4">
                                @php
                                    $jenisClass = match ($i->jenis) {
                                        'sakit'
                                            => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'cuti' => 'bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400',
                                        default => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $jenisClass }}">
                                    {{ ucfirst($i->jenis) }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                {{ $i->tanggal_mulai->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $i->tanggal_selesai->format('d/m/Y') }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $i->jumlahHari() }} hari
                            </td>

                            <td class="max-w-xs truncate px-6 py-4" title="{{ $i->alasan }}">
                                {{ $i->alasan }}
                            </td>

                            <td class="px-6 py-4">
                                @php
                                    $statusClass = match ($i->status) {
                                        'disetujui'
                                            => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'ditolak' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                        default
                                            => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                    };
                                @endphp

                                <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                                    {{ ucfirst($i->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-slate-400">
                                <i class="bi bi-file-earmark-x mb-3 block text-4xl text-gray-400 dark:text-slate-600"></i>
                                Belum ada pengajuan izin.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($izin->hasPages())
            <div class="border-t border-gray-200 bg-gray-50 px-6 py-4 dark:border-slate-700 dark:bg-slate-800">
                {{ $izin->links() }}
            </div>
        @endif
    </div>
@endsection
