@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex items-center justify-between">

            <div>
                <h2 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Data Karyawan
                </h2>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola seluruh data karyawan.
                </p>
            </div>

            <div class="flex items-center gap-3">

                <form action="{{ route('admin.karyawan.index') }}" method="GET">

                    <div class="relative">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />

                        </svg>

                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..."
                            class="w-72 rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-600 dark:bg-slate-800 dark:text-white">

                    </div>

                </form>

                <a href="{{ route('admin.karyawan.create') }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                        stroke="currentColor" class="h-5 w-5">

                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />

                    </svg>

                    Tambah Karyawan

                </a>

            </div>

        </div>

        {{-- Table --}}
        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-100 dark:bg-slate-700">

                        <tr
                            class="text-left text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">

                            <th class="px-6 py-4">No</th>
                            <th class="px-6 py-4">NIP</th>
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Bidang</th>
                            <th class="px-6 py-4">Jabatan</th>
                            <th class="px-6 py-4">No HP</th>
                            <th class="px-6 py-4">Tgl Masuk</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">

                        @forelse($karyawan as $k)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-700/40">

                                <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 text-sm font-medium text-slate-500">
                                    {{ $k->nip }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-800 dark:text-white">
                                        {{ $k->nama }}
                                    </div>

                                    <div class="text-sm text-slate-500">
                                        {{ $k->user->email ?? '-' }}
                                    </div>

                                </td>

                                <td class="px-6 py-4">
                                    {{ $k->jabatan?->bidang?->nama ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $k->jabatan?->nama ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $k->no_hp ?? '-' }}
                                </td>

                                <td class="px-6 py-4">
                                    {{ $k->tanggal_masuk->format('d/m/Y') }}
                                </td>

                                <td class="px-6 py-4">

                                    @php
                                        $roleClass = match ($k->user->role ?? '') {
                                            'admin'
                                                => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                            'pimpinan'
                                                => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                                            default
                                                => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                                        };
                                    @endphp

                                    <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $roleClass }}">
                                        {{ ucfirst($k->user->role ?? '-') }}
                                    </span>

                                </td>

                                <td class="px-6 py-4">

                                    @if ($k->status == 'aktif')
                                        <span
                                            class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700 dark:bg-green-900/40 dark:text-green-300">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700 dark:bg-red-900/40 dark:text-red-300">
                                            Nonaktif
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.karyawan.edit', $k) }}"
                                            class="rounded-lg bg-amber-500 p-2 text-white transition hover:bg-amber-600">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="h-5 w-5">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />

                                            </svg>

                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.karyawan.destroy', $k) }}" method="POST"
                                            onsubmit="return confirm('Hapus karyawan {{ $k->nama }}? Akun login juga akan dihapus.')">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                class="rounded-lg bg-red-600 p-2 text-white transition hover:bg-red-700">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor" class="h-5 w-5">

                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21.75H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0A48.11 48.11 0 0 1 12 5.25c1.18 0 2.347.043 3.478.128m-10.434.412L6.75 4.5A2.25 2.25 0 0 1 9 2.25h6A2.25 2.25 0 0 1 17.25 4.5l.706 1.29" />

                                                </svg>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="9" class="px-6 py-12 text-center">

                                    <div class="flex flex-col items-center gap-3 text-slate-500">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="h-12 w-12">

                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M18 18.72a9.094 9.094 0 0 0 3.742-.479A3 3 0 0 0 20.25 15H3.75A3 3 0 0 0 2.258 18.24 9.094 9.094 0 0 0 6 18.72m12 0A9.023 9.023 0 0 1 12 21a9.023 9.023 0 0 1-6-.72m12 0V15a6 6 0 0 0-12 0v5.72M15 7.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />

                                        </svg>

                                        <span>Belum ada data karyawan.</span>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($karyawan->hasPages())
                <div class="border-t border-slate-200 p-4 dark:border-slate-700">

                    {{ $karyawan->links() }}

                </div>
            @endif
        </div>
    </div>

@endsection
