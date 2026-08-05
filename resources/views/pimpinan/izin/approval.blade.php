@extends('layouts.app')

@section('title', 'Approval Izin')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            Approval Izin
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Kelola pengajuan izin dari seluruh karyawan.
        </p>

    </div>

    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="border-b border-slate-200 p-6 dark:border-slate-800">

            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Daftar Pengajuan Izin
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Karyawan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Jenis
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Durasi
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Alasan
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Lampiran
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse($izin as $i)
                    <tr class="hover:bg-slate-50 transition dark:hover:bg-slate-800/50">

                        <td class="px-6 py-4">

                            <div class="font-medium text-slate-800 dark:text-white">
                                {{ $i->karyawan->nama }}
                            </div>

                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $i->karyawan->jabatan?->nama }}
                            </div>

                        </td>

                        <td class="px-6 py-4">

                            @php
                            $jenis = match ($i->jenis) {
                            'sakit'
                            => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            default
                            => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                            };
                            @endphp

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $jenis }}">
                                {{ ucfirst($i->jenis) }}
                            </span>

                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">

                            <div>
                                {{ $i->tanggal_mulai->format('d/m/Y') }}
                            </div>

                            <div class="text-sm text-slate-500">
                                s/d {{ $i->tanggal_selesai->format('d/m/Y') }}
                            </div>

                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $i->jumlahHari() }} hari
                        </td>

                        <td class="max-w-xs px-6 py-4 text-slate-600 dark:text-slate-400">
                            <p class="truncate" title="{{ $i->alasan }}">
                                {{ $i->alasan }}
                            </p>
                        </td>

                        <td class="px-6 py-4">

                            @if ($i->lampiran)
                            <a href="{{ asset('storage/' . $i->lampiran) }}" target="_blank"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-sm transition hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800">

                                Lihat

                            </a>
                            @else
                            <span class="text-slate-400">
                                -
                            </span>
                            @endif

                        </td>

                        <td class="px-6 py-4">

                            @php
                            $status = match ($i->status) {
                            'disetujui'
                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                            'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                            default
                            => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            };
                            @endphp

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $status }}">
                                {{ ucfirst($i->status) }}
                            </span>

                        </td>

                        <td class="px-6 py-4">

                            @if ($i->status === 'pending')
                            <div class="flex gap-2">

                                <form
                                    action="{{ auth()->user()->isAdmin() ? route('admin.izin.approve', $i) : route('pimpinan.izin.approve', $i) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button onclick="return confirm('Setujui izin ini?')"
                                        class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">

                                        Setujui

                                    </button>

                                </form>

                                <form
                                    action="{{ auth()->user()->isAdmin() ? route('admin.izin.reject', $i) : route('pimpinan.izin.reject', $i) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button onclick="return confirm('Tolak izin ini?')"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">

                                        Tolak

                                    </button>

                                </form>

                            </div>
                            @else
                            <div class="text-sm text-slate-500 dark:text-slate-400">

                                <div>
                                    {{ $i->penyetuju?->name ?? '-' }}
                                </div>

                                <div>
                                    {{ $i->disetujui_at?->format('d/m/Y H:i') }}
                                </div>

                            </div>
                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="8" class="px-6 py-12 text-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586A2 2 0 0114 3.586L18.414 8A2 2 0 0119 9.414V19a2 2 0 01-2 2z" />

                            </svg>

                            <p class="text-slate-500 dark:text-slate-400">
                                Tidak ada pengajuan izin yang perlu diproses.
                            </p>

                        </td>

                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($izin->hasPages())
        <div class="border-t border-slate-200 p-6 dark:border-slate-800">

            {{ $izin->links() }}

        </div>
        @endif

    </div>

</div>

@endsection