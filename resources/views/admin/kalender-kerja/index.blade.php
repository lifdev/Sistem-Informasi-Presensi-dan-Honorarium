@extends('layouts.app')

@section('title', 'Kalender Kerja')

@section('content')

<div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">

        <div>

            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Kalender Kerja
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Generate dan kelola kalender hari kerja.
            </p>

        </div>

    </div>

    <!-- Form -->
    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div
            class="border-b border-slate-200 p-6 dark:border-slate-800">

            <form method="POST" action="{{ route('admin.kalender-kerja.generate') }}"
                class="flex flex-wrap items-end gap-4">

                @csrf

                <div>

                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Bulan
                    </label>

                    <select
                        name="bulan"
                        class="rounded-xl border border-slate-300 px-4 py-2.5 dark:border-slate-700 dark:bg-slate-800 dark:text-white">

                        @for($i = 1; $i <= 12; $i++)

                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                            </option>

                            @endfor

                    </select>

                </div>

                <div>

                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Tahun
                    </label>

                    <input
                        type="number"
                        name="tahun"
                        value="{{ $tahun }}"
                        class="rounded-xl border border-slate-300 px-4 py-2.5 dark:border-slate-700 dark:bg-slate-800 dark:text-white">

                </div>

                <button
                    type="submit"
                    class="rounded-xl bg-blue-600 px-5 py-2.5 font-medium text-white transition hover:bg-blue-700">

                    Generate Hari Kerja

                </button>

            </form>

        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-slate-100 dark:bg-slate-800">

                    <tr>

                        <th class="px-6 py-4 text-center text-sm font-semibold">
                            No
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Tanggal
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Hari
                        </th>

                        <th class="px-6 py-4 text-center text-sm font-semibold">
                            Status
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold">
                            Keterangan
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    @forelse($kalender as $item)

                    <tr class="border-b border-slate-200 hover:bg-slate-50 dark:border-slate-700 dark:hover:bg-slate-800/50">

                        <td class="px-6 py-4 text-center text-slate-500 dark:text-slate-400">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $item->tanggal->translatedFormat('d M Y') }}
                        </td>

                        <td class="px-6 py-4 text-slate-700 dark:text-slate-300">
                            {{ $item->nama_hari }}
                        </td>

                        <td class="px-6 py-4 text-center">

                            <form action="{{ route('admin.kalender-kerja.update', $item) }}"
                                method="POST">

                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="is_hari_kerja" value="0">

                                <label class="relative inline-flex cursor-pointer items-center">

                                    <input
                                        type="checkbox"
                                        name="is_hari_kerja"
                                        value="1"
                                        class="peer sr-only"
                                        {{ $item->is_hari_kerja ? 'checked' : '' }}
                                        onchange="this.form.submit()">

                                    <div
                                        class="peer h-6 w-11 rounded-full bg-slate-300 transition-all
                       after:absolute after:left-[2px] after:top-[2px]
                       after:h-5 after:w-5 after:rounded-full
                       after:bg-white after:transition-all
                       peer-checked:bg-emerald-600
                       peer-checked:after:translate-x-full
                       dark:bg-slate-600">
                                    </div>

                                </label>

                            </form>

                        </td>

                        <td class="px-6 py-4">

                            <form
                                action="{{ route('admin.kalender-kerja.update', $item) }}"
                                method="POST"
                                class="flex items-center gap-2">

                                @csrf
                                @method('PATCH')

                                @if($item->is_hari_kerja)
                                <input type="hidden" name="is_hari_kerja" value="1">
                                @endif

                                <input
                                    type="text"
                                    name="keterangan"
                                    value="{{ $item->keterangan }}"
                                    placeholder="Contoh: Libur Nasional"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm
                   focus:border-blue-500 focus:ring-2 focus:ring-blue-200
                   dark:border-slate-600 dark:bg-slate-800 dark:text-white">

                                <button
                                    class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">

                                    Simpan

                                </button>

                            </form>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5" class="px-6 py-12 text-center">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="mx-auto mb-4 h-14 w-14 text-slate-300"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.5">

                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10m2 8H5a2 2 0 01-2-2V7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2z" />

                            </svg>

                            <p class="text-slate-500 dark:text-slate-400">
                                Belum ada data kalender kerja.
                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if ($kalender->isNotEmpty())
        @php
        $totalHariKerja = $kalender->where('is_hari_kerja', true)->count();
        $totalLibur = $kalender->where('is_hari_kerja', false)->count();
        @endphp

        <div class="flex flex-wrap gap-4 border-t border-slate-200 px-6 py-5 dark:border-slate-800">

            <div class="flex items-center gap-2 rounded-xl bg-emerald-50 px-4 py-2.5 dark:bg-emerald-900/20">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                <span class="text-sm text-slate-600 dark:text-slate-300">
                    Hari kerja bulan ini:
                    <span class="font-semibold text-emerald-700 dark:text-emerald-400">{{ $totalHariKerja }} hari</span>
                </span>
            </div>

            <div class="flex items-center gap-2 rounded-xl bg-slate-100 px-4 py-2.5 dark:bg-slate-800">
                <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                <span class="text-sm text-slate-600 dark:text-slate-300">
                    Libur bulan ini:
                    <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $totalLibur }} hari</span>
                </span>
            </div>

        </div>
        @endif

    </div>

</div>

@endsection