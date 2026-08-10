@extends('layouts.app')

@section('title', 'Log Aktivitas Sistem')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            Log Aktivitas Sistem
        </h1>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Riwayat aktivitas seluruh pengguna di sistem (login, absen, izin, honorarium, dll).
        </p>
    </div>

    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="flex flex-col gap-4 border-b border-slate-200 p-6 dark:border-slate-800 lg:flex-row lg:items-center lg:justify-between">

            <form method="GET" class="flex flex-wrap items-center gap-3">

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / deskripsi..."
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-800">

                <select name="aktivitas"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-800">
                    <option value="">Semua Aktivitas</option>
                    @foreach ($daftarAktivitas as $a)
                    <option value="{{ $a }}" {{ request('aktivitas') == $a ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $a)) }}
                    </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="rounded-xl border border-slate-300 px-4 py-2.5 text-sm dark:border-slate-700 dark:bg-slate-800">

                <button class="rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-700">
                    Filter
                </button>

                @if (request('search') || request('aktivitas') || request('tanggal'))
                <a href="{{ route('admin.log-aktivitas.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">
                    Reset
                </a>
                @endif

            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 dark:bg-slate-800">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Waktu</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Pengguna</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Aktivitas</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">Deskripsi</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold">IP Address</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                    @forelse ($log as $item)
                    <tr class="hover:bg-slate-50 transition dark:hover:bg-slate-800/50">
                        <td class="whitespace-nowrap px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $item->created_at->translatedFormat('d M Y, H:i:s') }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800 dark:text-white">
                                {{ $item->nama ?? '-' }}
                            </div>
                            @if ($item->role)
                            <div class="text-xs text-slate-500 dark:text-slate-400">
                                {{ ucfirst($item->role) }}
                            </div>
                            @endif
                        </td>

                        <td class="px-6 py-4">
                            @php
                            $warna = match (true) {
                            str_contains($item->aktivitas, 'hapus') || str_contains($item->aktivitas, 'reject')
                            => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                            str_contains($item->aktivitas, 'login')
                            => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300',
                            str_contains($item->aktivitas, 'logout')
                            => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300',
                            default
                            => 'bg-sky-100 text-sky-700 dark:bg-sky-900/30 dark:text-sky-300',
                            };
                            @endphp
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $warna }}">
                                {{ ucwords(str_replace('_', ' ', $item->aktivitas)) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            {{ $item->deskripsi ?? '-' }}
                        </td>

                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                            {{ $item->ip_address ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z" />
                            </svg>
                            <p class="text-slate-500 dark:text-slate-400">
                                Belum ada log aktivitas.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($log->hasPages())
        <div class="border-t border-slate-200 p-6 dark:border-slate-800">
            {{ $log->appends(request()->query())->links() }}
        </div>
        @endif

    </div>
</div>

@endsection