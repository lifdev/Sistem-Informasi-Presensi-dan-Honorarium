@extends('layouts.app')

@section('title', 'Data Jabatan')

@section('content')

    <div class="space-y-6">

        <div class="flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Data Jabatan
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola seluruh data jabatan pada sistem.
                </p>

            </div>

            <a href="{{ route('admin.jabatan.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />

                </svg>

                Tambah Jabatan

            </a>

        </div>

        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-100 dark:bg-slate-700">

                        <tr
                            class="text-left text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">

                            <th class="px-6 py-4">
                                No
                            </th>

                            <th class="px-6 py-4">
                                Bidang
                            </th>

                            <th class="px-6 py-4">
                                Nama Jabatan
                            </th>

                            <th class="px-6 py-4">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">

                        @forelse($jabatans as $jabatan)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-700/40">

                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-500">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                    {{ $jabatan->bidang->nama }}
                                </td>

                                <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                                    {{ $jabatan->nama }}
                                </td>

                                <td class="px-6 py-4">

                                    <div class="flex justify-center gap-2">

                                        <a href="{{ route('admin.jabatan.edit', $jabatan) }}"
                                            class="rounded-lg bg-amber-500 p-2 text-white transition hover:bg-amber-600">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.8" stroke="currentColor" class="h-5 w-5">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />

                                            </svg>

                                        </a>

                                        <form action="{{ route('admin.jabatan.destroy', $jabatan) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus jabatan ini?')">

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

                                <td colspan="5" class="px-6 py-12 text-center">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 6v6l4 2M6 20h12a2 2 0 002-2V8l-4-4H6a2 2 0 00-2 2v12a2 2 0 002 2z" />

                                    </svg>

                                    <p class="text-slate-500 dark:text-slate-400">
                                        Belum ada data jabatan.
                                    </p>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection
