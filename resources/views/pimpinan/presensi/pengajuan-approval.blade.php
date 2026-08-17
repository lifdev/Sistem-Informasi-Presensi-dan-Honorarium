@extends('layouts.app')

@section('title', 'Approval Presensi Susulan')

@section('content')

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            Approval Presensi Susulan
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Kelola pengajuan presensi susulan dari karyawan yang lupa melakukan absen.
        </p>

    </div>

    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="border-b border-slate-200 p-6 dark:border-slate-800">

            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Daftar Pengajuan Presensi Susulan
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
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Jam Masuk
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

                    @forelse($pengajuan as $p)
                    <tr class="hover:bg-slate-50 transition dark:hover:bg-slate-800/50">

                        <td class="px-6 py-4">

                            <div class="font-medium text-slate-800 dark:text-white">
                                {{ $p->karyawan->nama }}
                            </div>

                            <div class="text-sm text-slate-500 dark:text-slate-400">
                                {{ $p->karyawan->jabatan?->nama }}
                            </div>

                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $p->tanggal->format('d/m/Y') }}
                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ \Illuminate\Support\Carbon::parse($p->jam_masuk)->format('H:i') }}
                        </td>

                        <td class="max-w-xs px-6 py-4 text-slate-600 dark:text-slate-400">
                            <p class="truncate" title="{{ $p->alasan }}">
                                {{ $p->alasan }}
                            </p>
                        </td>

                        <td class="px-6 py-4">

                            @if ($p->lampiran)
                            <a href="{{ asset('storage/' . $p->lampiran) }}" target="_blank"
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
                            $status = match ($p->status) {
                            'disetujui'
                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                            'ditolak' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                            default
                            => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                            };
                            @endphp

                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $status }}">
                                {{ ucfirst($p->status) }}
                            </span>

                        </td>

                        <td class="px-6 py-4">

                            @if ($p->status === 'pending')
                            <div class="flex gap-2">

                                <form
                                    action="{{ auth()->user()->isAdmin() ? route('admin.presensi.pengajuan.approve', $p) : route('pimpinan.presensi.pengajuan.approve', $p) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button onclick="return confirm('Setujui pengajuan presensi ini?')"
                                        class="rounded-lg bg-emerald-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">

                                        Setujui

                                    </button>

                                </form>

                                <form
                                    action="{{ auth()->user()->isAdmin() ? route('admin.presensi.pengajuan.reject', $p) : route('pimpinan.presensi.pengajuan.reject', $p) }}"
                                    method="POST">

                                    @csrf
                                    @method('PATCH')

                                    <button onclick="return confirm('Tolak pengajuan presensi ini?')"
                                        class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">

                                        Tolak

                                    </button>

                                </form>

                            </div>
                            @else
                            <div class="text-sm text-slate-500 dark:text-slate-400">

                                <div>
                                    {{ $p->penyetuju?->name ?? '-' }}
                                </div>

                                <div>
                                    {{ $p->disetujui_at?->format('d/m/Y H:i') }}
                                </div>

                            </div>
                            @endif

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="px-6 py-12 text-center">

                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">

                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />

                            </svg>

                            <p class="text-slate-500 dark:text-slate-400">
                                Tidak ada pengajuan presensi susulan yang perlu diproses.
                            </p>

                        </td>

                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($pengajuan->hasPages())
        <div class="border-t border-slate-200 p-6 dark:border-slate-800">

            {{ $pengajuan->links() }}

        </div>
        @endif

    </div>

</div>

@endsection