@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')

    <div class="mx-auto max-w-5xl">

        <div
            class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">

            {{-- Header --}}
            <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-700">

                <div class="flex items-center gap-3">

                    <div class="rounded-xl bg-amber-100 p-3 text-amber-600 dark:bg-amber-900/40 dark:text-amber-300">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="h-6 w-6">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a2.25 2.25 0 1 1 3.182 3.182L10.582 17.13a4.5 4.5 0 0 1-1.897 1.13L6 19l.74-2.685a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z" />

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-xl font-bold text-slate-800 dark:text-white">
                            Edit Karyawan
                        </h2>

                        <p class="text-sm text-slate-500">
                            {{ $karyawan->nama }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Form --}}
            <form action="{{ route('admin.karyawan.update', $karyawan) }}" method="POST" class="space-y-8 p-6">

                @csrf
                @method('PUT')

                {{-- Data Pribadi --}}
                <div>

                    <h3 class="mb-5 text-lg font-semibold text-slate-800 dark:text-white">
                        Data Pribadi
                    </h3>

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                NIP
                            </label>

                            <input type="text" name="nip" value="{{ old('nip', $karyawan->nip) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none dark:border-slate-600 dark:bg-slate-900">

                            @error('nip')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama" value="{{ old('nama', $karyawan->nama) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:outline-none dark:border-slate-600 dark:bg-slate-900">

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Bidang
                            </label>

                            <select id="bidang"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}"
                                        {{ $karyawan->jabatan->bidang_id == $bidang->id ? 'selected' : '' }}>

                                        {{ $bidang->nama }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Jabatan
                            </label>

                            <select id="jabatan" name="jabatan_id"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}" data-bidang="{{ $jabatan->bidang_id }}"
                                        {{ old('jabatan_id', $karyawan->jabatan_id) == $jabatan->id ? 'selected' : '' }}>

                                        {{ $jabatan->nama }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Jenis Kelamin
                            </label>

                            <select name="jenis_kelamin"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                                <option value="L"
                                    {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>

                                <option value="P"
                                    {{ old('jenis_kelamin', $karyawan->jenis_kelamin) == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>

                            </select>

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                No HP
                            </label>

                            <input type="text" name="no_hp" value="{{ old('no_hp', $karyawan->no_hp) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Tanggal Masuk
                            </label>

                            <input type="date" name="tanggal_masuk"
                                value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk->format('Y-m-d')) }}"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Status
                            </label>

                            <select name="status"
                                class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                                <option value="aktif" {{ old('status', $karyawan->status) == 'aktif' ? 'selected' : '' }}>
                                    Aktif
                                </option>

                                <option value="nonaktif"
                                    {{ old('status', $karyawan->status) == 'nonaktif' ? 'selected' : '' }}>
                                    Nonaktif
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="mt-6">

                        <label class="mb-2 block text-sm font-medium">
                            Alamat
                        </label>

                        <textarea name="alamat" rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">{{ old('alamat', $karyawan->alamat) }}</textarea>

                    </div>

                </div>

                {{-- Info --}}
                <div
                    class="rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-700 dark:border-blue-800 dark:bg-blue-900/30 dark:text-blue-300">

                    Email, password, dan role belum dapat diubah melalui halaman ini.

                </div>

                {{-- Button --}}
                <div class="flex gap-3">

                    <button
                        class="inline-flex items-center gap-2 rounded-xl bg-amber-500 px-6 py-3 font-medium text-white transition hover:bg-amber-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                            stroke="currentColor" class="h-5 w-5">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.862 5.487A2.25 2.25 0 1 1 20.045 8.67L10.5 18.216 6 19.5l1.284-4.5 9.578-9.513Z" />

                        </svg>

                        Update Data

                    </button>

                    <a href="{{ route('admin.karyawan.index') }}"
                        class="rounded-xl border border-slate-300 px-6 py-3 font-medium transition hover:bg-slate-100 dark:border-slate-600 dark:hover:bg-slate-700">

                        Batal

                    </a>

                </div>

            </form>

        </div>

    </div>

    @push('scripts')
        <script>
            const bidang = document.getElementById('bidang');
            const jabatan = document.getElementById('jabatan');

            function filterJabatan() {

                let bidangId = bidang.value;

                [...jabatan.options].forEach(option => {

                    if (option.dataset.bidang === undefined) return;

                    option.hidden = option.dataset.bidang != bidangId;

                });

            }

            filterJabatan();

            bidang.addEventListener('change', () => {

                filterJabatan();
                jabatan.value = "";

            });
        </script>
    @endpush

@endsection
