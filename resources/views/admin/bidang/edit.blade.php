@extends('layouts.app')

@section('title', 'Edit Bidang')

@section('content')

<div class="mx-auto max-w-3xl">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Edit Bidang
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Perbarui informasi bidang.
            </p>
        </div>

        <a href="{{ route('admin.bidang.index') }}"
            class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">
            Kembali
        </a>
    </div>

    <div
        class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
        <div class="border-b border-slate-200 p-6 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <div class="rounded-xl bg-amber-100 p-3 text-amber-600 dark:bg-amber-900/30">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">

                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.586-9.414a2 2 0 112.828 2.828L12 15l-4 1 1-4 8.414-8.414z" />
                    </svg>
                </div>

                <div>
                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                        Form Edit Bidang
                    </h2>

                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        Ubah data bidang sesuai kebutuhan.
                    </p>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.bidang.update', $bidang) }}" method="POST" class="space-y-6 p-6">

            @csrf
            @method('PUT')

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Nama Bidang
                </label>

                <input type="text" name="nama" value="{{ old('nama', $bidang->nama) }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">

                @error('nama')
                <p class="mt-2 text-sm text-red-500">
                    {{ $message }}
                </p>
                @enderror
            </div>

            <div>
                <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    Deskripsi
                </label>

                <textarea name="deskripsi" rows="5"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white">{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
            </div>

            <div class="flex justify-end gap-3 border-t border-slate-200 pt-6 dark:border-slate-800">
                <a href="{{ route('admin.bidang.index') }}"
                    class="rounded-xl border border-slate-300 px-5 py-3 font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">
                    Batal
                </a>

                <button type="submit"
                    class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-6 py-3 font-medium text-white transition hover:bg-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    Update Bidang
                </button>
            </div>
        </form>
    </div>
</div>

@endsection