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
                Kelola gaji pokok setiap jabatan. Potongan alpha dihitung otomatis. Bonus tidak diatur di sini &mdash;
                bonus bersifat tidak rutin dan diinput langsung per karyawan di halaman
                <span class="font-medium">Detail Honorarium</span> tiap bulan.
            </p>
        </div>
    </div>

    @if (session('success'))
    <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700 dark:border-emerald-900 dark:bg-emerald-900/20 dark:text-emerald-400">
        {{ session('success') }}
    </div>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        @forelse ($data as $item)
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-lg dark:border-slate-800 dark:bg-slate-900">

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
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-3.314 0-6 2.239-6 5v3h12v-3c0-2.761-2.686-5-6-5zm0-6a3 3 0 100 6 3 3 0 000-6z" />
                        </svg>
                    </div>
                </div>
            </div>

            <form action="{{ route('admin.pengaturan.gaji.update', $item) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="gaji_pokok_{{ $item->id }}" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Gaji Pokok
                    </label>

                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                        <input
                            type="number"
                            id="gaji_pokok_{{ $item->id }}"
                            name="gaji_pokok"
                            value="{{ old('gaji_pokok', $item->gaji_pokok) }}"
                            min="0"
                            step="1000"
                            class="w-full rounded-xl border bg-white py-3 pl-12 pr-4 outline-none transition focus:ring-2 dark:bg-slate-800
                                    {{ $errors->has('gaji_pokok') ? 'border-red-400 focus:border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-200 dark:border-slate-700' }}">
                    </div>

                    @error('gaji_pokok')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Potongan Alpha (per hari)
                    </label>

                    <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-800/50">
                        <p class="text-sm font-semibold text-slate-700 dark:text-slate-200">
                            Rp {{ number_format($item->potongan_alpha, 0, ',', '.') }}
                        </p>
                        <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                            Dihitung otomatis dari gaji pokok &divide; jumlah hari kerja bulan berjalan. Diperbarui saat gaji pokok disimpan.
                        </p>
                    </div>
                </div>

                <div class="rounded-xl border border-dashed border-blue-200 bg-blue-50 px-4 py-3 dark:border-blue-900 dark:bg-blue-900/10">
                    <p class="text-sm font-semibold text-blue-700 dark:text-blue-300">
                        Bonus tidak diatur per jabatan
                    </p>
                    <p class="mt-1 text-xs text-blue-600/80 dark:text-blue-400/80">
                        Bonus bersifat tidak rutin dan berbeda tiap karyawan, jadi diinput langsung per orang di halaman Detail Honorarium saat honorarium bulan itu masih berstatus Draft.
                    </p>
                </div>

                <div class="flex justify-end border-t border-slate-200 pt-5 dark:border-slate-800">
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
        @empty
        <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center dark:border-slate-700 dark:bg-slate-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 014-4h5m-5-4h6m-9 10H6a2 2 0 01-2-2V7a2 2 0 012-2h8l4 4v8a2 2 0 01-2 2h-4" />
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