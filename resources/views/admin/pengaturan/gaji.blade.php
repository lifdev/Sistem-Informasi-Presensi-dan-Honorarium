@extends('layouts.app')

@section('title', 'Pengaturan Gaji')

@section('content')

    <div class="mx-auto max-w-7xl">

        <div class="mb-6 flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Pengaturan Gaji
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Kelola nominal gaji pokok, tunjangan, dan potongan setiap jabatan.
                </p>

            </div>

        </div>

        <div class="grid gap-6 lg:grid-cols-2">

            @forelse($data as $item)
                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">

                    <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                        <div class="flex items-center justify-between">

                            <div>

                                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                                    {{ $item->jabatan->nama }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    {{ $item->jabatan->bidang->nama }}
                                </p>

                            </div>

                            <div class="rounded-xl bg-blue-100 p-3 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 8c-3.314 0-6 2.239-6 5v3h12v-3c0-2.761-2.686-5-6-5zm0-6a3 3 0 100 6 3 3 0 000-6z" />

                                </svg>

                            </div>

                        </div>

                    </div>

                    <form action="{{ route('admin.pengaturan.gaji.update', $item) }}" method="POST" class="space-y-6 p-6">

                        @csrf
                        @method('PUT')

                        <div>

                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                Gaji Pokok
                            </label>

                            <div class="relative">

                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                    Rp
                                </span>

                                <input type="number" name="gaji_pokok" value="{{ $item->gaji_pokok }}" min="0"
                                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            </div>

                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">

                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Tunjangan Hadir / Hari
                                </label>

                                <div class="relative">

                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        Rp
                                    </span>

                                    <input type="number" name="tunjangan_hadir" value="{{ $item->tunjangan_hadir }}"
                                        min="0"
                                        class="w-full rounded-xl border border-green-200 bg-green-50 py-3 pl-12 pr-4 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-200 dark:border-green-900 dark:bg-green-950/30">

                                </div>

                            </div>

                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Potongan Alpha / Hari
                                </label>

                                <div class="relative">

                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        Rp
                                    </span>

                                    <input type="number" name="potongan_alpha" value="{{ $item->potongan_alpha }}"
                                        min="0"
                                        class="w-full rounded-xl border border-red-200 bg-red-50 py-3 pl-12 pr-4 outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-200 dark:border-red-900 dark:bg-red-950/30">

                                </div>

                            </div>

                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Potongan Izin / Hari
                                </label>

                                <div class="relative">

                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        Rp
                                    </span>

                                    <input type="number" name="potongan_izin" value="{{ $item->potongan_izin }}"
                                        min="0"
                                        class="w-full rounded-xl border border-amber-200 bg-amber-50 py-3 pl-12 pr-4 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-200 dark:border-amber-900 dark:bg-amber-950/30">

                                </div>

                            </div>

                            <div>

                                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                                    Potongan Sakit / Hari
                                </label>

                                <div class="relative">

                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                                        Rp
                                    </span>

                                    <input type="number" name="potongan_sakit" value="{{ $item->potongan_sakit }}"
                                        min="0"
                                        class="w-full rounded-xl border border-orange-200 bg-orange-50 py-3 pl-12 pr-4 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-200 dark:border-orange-900 dark:bg-orange-950/30">

                                </div>

                            </div>

                        </div>

                        <div class="flex justify-end border-t border-slate-200 pt-5 dark:border-slate-800">

                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                                Simpan Perubahan

                            </button>

                        </div>

                    </form>

                </div>

            @empty

                <div
                    class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center dark:border-slate-700 dark:bg-slate-900">

                    <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 17v-2a4 4 0 014-4h5m-5-4h6m-9 10H6a2 2 0 01-2-2V7a2 2 0 012-2h8l4 4v8a2 2 0 01-2 2h-4" />

                    </svg>

                    <h3 class="mt-5 text-lg font-semibold text-slate-700 dark:text-slate-200">
                        Belum Ada Data
                    </h3>

                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                        Pengaturan gaji belum tersedia.
                    </p>

                </div>
            @endforelse

        </div>

    </div>

@endsection
