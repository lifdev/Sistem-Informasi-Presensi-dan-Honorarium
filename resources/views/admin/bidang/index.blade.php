@extends('layouts.app')

@section('title', 'Data Bidang')

@section('content')

<div class="space-y-6">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Data Bidang
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Kelola seluruh bidang pada yayasan.
            </p>
        </div>

        <a href="{{ route('admin.bidang.create') }}"
            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Bidang
        </a>
    </div>

    <div
        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 dark:bg-slate-700">
                    <tr
                        class="text-left text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama Bidang</th>
                        <th class="px-6 py-4">Jumlah Karyawan</th>
                        <th class="px-6 py-4">Deskripsi</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($bidangs as $bidang)
                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-700/40">
                        <td class="px-6 py-4 text-sm font-medium text-slate-500">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800 dark:text-white">
                                {{ $bidang->nama }}
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <span
                                class="inline-flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                {{ $bidang->jumlah_karyawan }} Orang
                            </span>
                        </td>

                        <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                            {{ $bidang->deskripsi ?? '-' }}
                        </td>

                        <td class="px-6 py-4">

                            <div class="flex justify-center gap-2">

                                {{-- Edit --}}
                                <a href="{{ route('admin.bidang.edit', $bidang) }}"
                                    class="rounded-lg bg-amber-500 p-2 text-white transition hover:bg-amber-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.8" stroke="currentColor" class="h-5 w-5">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />
                                    </svg>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.bidang.destroy', $bidang) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus bidang ini?')">

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
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center gap-3 text-slate-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="h-12 w-12">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7h18M3 12h18M3 17h18" />
                                </svg>
                                <span>Belum ada data bidang.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection