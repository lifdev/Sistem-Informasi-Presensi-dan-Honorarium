@extends('layouts.app')

@section('title', 'Detail Honorarium')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    <div class="flex flex-wrap items-center justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Detail Honorarium
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Detail honorarium karyawan.
            </p>

        </div>

        <div class="flex gap-2">

            <a href="{{ route('admin.laporan.slip', $honorarium) }}" target="_blank"
                class="rounded-xl bg-red-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-red-700">

                Cetak Slip

            </a>

            <a href="{{ route('admin.honorarium.index') }}"
                class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800">

                Kembali

            </a>

        </div>

    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="border-b border-slate-200 p-6 dark:border-slate-800">

            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Informasi Karyawan
            </h2>

        </div>

        <div class="grid gap-8 p-6 md:grid-cols-2">

            <div class="space-y-4">

                <div>

                    <p class="text-sm text-slate-500">
                        Nama
                    </p>

                    <p class="font-semibold text-slate-800 dark:text-white">
                        {{ $honorarium->karyawan->nama }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        NIP
                    </p>

                    <p class="text-slate-700 dark:text-slate-300">
                        {{ $honorarium->karyawan->nip }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Bidang
                    </p>

                    <p class="text-slate-700 dark:text-slate-300">
                        {{ $honorarium->karyawan->jabatan?->bidang?->nama ?? '-' }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Jabatan
                    </p>

                    <p class="text-slate-700 dark:text-slate-300">
                        {{ $honorarium->karyawan->jabatan?->nama ?? '-' }}
                    </p>

                </div>

            </div>

            <div class="space-y-4">

                <div>

                    <p class="text-sm text-slate-500">
                        Periode
                    </p>

                    <p class="font-semibold text-slate-800 dark:text-white">
                        {{ $honorarium->namaBulan() }}
                        {{ $honorarium->tahun }}
                    </p>

                </div>

                <div>

                    <p class="text-sm text-slate-500">
                        Status
                    </p>

                    @if ($honorarium->status == 'final')
                    <span
                        class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-semibold text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                        Final
                    </span>
                    @else
                    <span
                        class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-sm font-semibold text-amber-700 dark:bg-amber-900/30 dark:text-amber-300">
                        Draft
                    </span>
                    @endif

                </div>

            </div>

        </div>

    </div>

    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="border-b border-slate-200 p-6 dark:border-slate-800">

            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Rekap Kehadiran
            </h2>

        </div>

        <div class="grid gap-5 p-6 sm:grid-cols-2 lg:grid-cols-4">

            <div class="rounded-xl bg-emerald-50 p-5 text-center dark:bg-emerald-900/20">

                <div class="text-3xl font-bold text-emerald-600">
                    {{ $honorarium->total_hadir }}
                </div>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Hadir
                </p>

            </div>

            <div class="rounded-xl bg-sky-50 p-5 text-center dark:bg-sky-900/20">

                <div class="text-3xl font-bold text-sky-600">
                    {{ $honorarium->total_izin }}
                </div>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Izin
                </p>

            </div>

            <div class="rounded-xl bg-amber-50 p-5 text-center dark:bg-amber-900/20">

                <div class="text-3xl font-bold text-amber-600">
                    {{ $honorarium->total_sakit }}
                </div>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Sakit
                </p>

            </div>

            <div class="rounded-xl bg-red-50 p-5 text-center dark:bg-red-900/20">

                <div class="text-3xl font-bold text-red-600">
                    {{ $honorarium->total_alpha }}
                </div>

                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">
                    Alpha
                </p>

            </div>

        </div>

    </div>

    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

        <div class="border-b border-slate-200 p-6 dark:border-slate-800">

            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                Rincian Honorarium
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <tbody class="divide-y divide-slate-200 dark:divide-slate-800">

                    <tr>

                        <td class="px-6 py-4 text-slate-500 align-top">
                            @if ($honorarium->isPerHadir())
                            Honorarium ({{ $honorarium->total_hadir }} hari hadir)
                            <p class="mt-1 text-xs font-normal text-slate-400">
                                Tarif Rp {{ number_format($honorarium->tarif_per_hadir, 0, ',', '.') }} / hari hadir.
                            </p>
                            @else
                            Honorarium Pokok
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right font-semibold text-slate-800 dark:text-white">
                            Rp {{ number_format($honorarium->honorarium_pokok, 0, ',', '.') }}
                        </td>

                    </tr>

                    <tr>

                        <td class="px-6 py-4 text-slate-500 align-top">
                            Bonus
                            <p class="mt-1 text-xs font-normal text-slate-400">
                                Tidak rutin, diisi manual per karyawan.
                            </p>
                        </td>

                        <td class="px-6 py-4 text-right">
                            @if ($honorarium->status === 'final')
                            <span class="font-semibold text-emerald-600">
                                + Rp {{ number_format($honorarium->bonus, 0, ',', '.') }}
                            </span>
                            @else
                            <form action="{{ route('admin.honorarium.bonus.update', $honorarium) }}" method="POST"
                                class="flex items-center justify-end gap-2">
                                @csrf
                                @method('PUT')

                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">Rp</span>
                                    <input
                                        type="number"
                                        name="bonus"
                                        value="{{ old('bonus', $honorarium->bonus) }}"
                                        min="0"
                                        step="1000"
                                        class="w-40 rounded-lg border bg-white py-2 pl-9 pr-3 text-right text-sm font-semibold outline-none transition focus:ring-2 dark:bg-slate-800
                                                {{ $errors->has('bonus') ? 'border-red-400 focus:border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-200 dark:border-slate-700' }}">
                                </div>

                                <button type="submit"
                                    class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                    Simpan
                                </button>
                            </form>

                            @error('bonus')
                            <p class="mt-1.5 text-right text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            @endif
                        </td>

                    </tr>

                    @if (!$honorarium->isPerHadir())
                    <tr>

                        <td class="px-6 py-4 text-slate-500">
                            Potongan
                            <span class="text-xs">
                                (Alpha {{ $honorarium->total_alpha }} hari)
                            </span>
                        </td>

                        <td class="px-6 py-4 text-right font-semibold text-red-600">
                            - Rp {{ number_format($honorarium->total_potongan, 0, ',', '.') }}
                        </td>

                    </tr>
                    @endif

                </tbody>

                <tfoot class="border-t border-slate-200 p-6 dark:border-slate-800">

                    <tr>

                        <th class="px-6 py-5 text-left text-lg font-bold text-slate-800 dark:text-white">
                            Honorarium Bersih
                        </th>

                        <th class="px-6 py-5 text-right text-2xl font-bold text-emerald-600">
                            Rp {{ number_format($honorarium->honorarium_bersih, 0, ',', '.') }}
                        </th>

                    </tr>

                </tfoot>

            </table>

        </div>

    </div>

</div>

@endsection