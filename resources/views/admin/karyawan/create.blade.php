@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')

    <div class="mx-auto max-w-5xl">

        <div class="mb-6 flex items-center justify-between">

            <div>

                <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                    Tambah Karyawan
                </h1>

                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    Tambahkan data karyawan beserta akun login.
                </p>

            </div>

            <a href="{{ route('admin.karyawan.index') }}"
                class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">

                Kembali

            </a>

        </div>

        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                <div class="flex items-center gap-3">

                    <div class="rounded-xl bg-blue-100 p-3 text-blue-600 dark:bg-blue-900/30">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">

                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 9v6m3-3h-6M16 21H8a4 4 0 01-4-4V7a4 4 0 014-4h5l7 7v7a4 4 0 01-4 4z" />

                        </svg>

                    </div>

                    <div>

                        <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                            Form Tambah Karyawan
                        </h2>

                        <p class="text-sm text-slate-500 dark:text-slate-400">
                            Lengkapi data berikut.
                        </p>

                    </div>

                </div>

            </div>

            <form action="{{ route('admin.karyawan.store') }}" method="POST" class="space-y-8 p-6">

                @csrf

                <div>

                    <h3 class="mb-5 text-lg font-semibold text-slate-800 dark:text-white">
                        Data Pribadi
                    </h3>

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                NIP
                            </label>

                            <input type="text" name="nip" value="{{ old('nip') }}" placeholder="Contoh : KRY001"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('nip')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Nama Lengkap
                            </label>

                            <input type="text" name="nama" value="{{ old('nama') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('nama')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror

                        </div>

                    </div>
                    <div class="grid gap-6 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Bidang
                            </label>

                            <select id="bidang"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                                <option value="">
                                    -- Pilih Bidang --
                                </option>

                                @foreach ($bidangs as $bidang)
                                    <option value="{{ $bidang->id }}">

                                        {{ $bidang->nama }}

                                    </option>
                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Jabatan
                            </label>

                            <select name="jabatan_id" id="jabatan"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800"
                                required>

                                <option value="">
                                    -- Pilih Jabatan --
                                </option>

                                @foreach ($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}" data-bidang="{{ $jabatan->bidang_id }}"
                                        {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>

                                        {{ $jabatan->nama }}

                                    </option>
                                @endforeach

                            </select>

                            @error('jabatan_id')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Jenis Kelamin
                            </label>

                            <select name="jenis_kelamin"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                                <option value="">
                                    -- Pilih --
                                </option>

                                <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>
                                    Laki-laki
                                </option>

                                <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>
                                    Perempuan
                                </option>

                            </select>

                            @error('jenis_kelamin')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                No. HP
                            </label>

                            <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('no_hp')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Tanggal Masuk
                            </label>

                            <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('tanggal_masuk')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Alamat
                            </label>

                            <input type="text" name="alamat" value="{{ old('alamat') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('alamat')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                </div>
                <div>

                    <h3 class="mb-5 text-lg font-semibold text-slate-800 dark:text-white">
                        Akun Login
                    </h3>

                    <div class="grid gap-6 md:grid-cols-2">

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Email
                            </label>

                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('email')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                        <div>

                            <label class="mb-2 block text-sm font-medium">
                                Password
                            </label>

                            <input type="password" name="password" placeholder="Minimal 6 karakter"
                                class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            @error('password')
                                <p class="mt-2 text-sm text-red-500">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    <div class="mt-6">

                        <label class="mb-2 block text-sm font-medium">
                            Role
                        </label>

                        <select name="role"
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            <option value="">
                                -- Pilih Role --
                            </option>

                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>

                            <option value="pimpinan" {{ old('role') == 'pimpinan' ? 'selected' : '' }}>
                                Pimpinan
                            </option>

                            <option value="karyawan" {{ old('role') == 'karyawan' ? 'selected' : '' }}>
                                Karyawan
                            </option>

                        </select>

                        @error('role')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                <div class="flex items-center justify-end gap-3 border-t border-slate-200 pt-6 dark:border-slate-800">

                    <a href="{{ route('admin.karyawan.index') }}"
                        class="rounded-xl border border-slate-300 px-5 py-3 font-medium text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:text-slate-200 dark:hover:bg-slate-800">

                        Batal

                    </a>

                    <button type="submit"
                        class="rounded-xl bg-blue-600 px-6 py-3 font-medium text-white transition hover:bg-blue-700">

                        Simpan Karyawan

                    </button>

                </div>

            </form>

        </div>

    </div>

    @push('scripts')
        <script>
            const bidang = document.getElementById('bidang');
            const jabatan = document.getElementById('jabatan');

            bidang.addEventListener('change', function() {

                let bidangId = this.value;

                [...jabatan.options].forEach(function(option) {

                    if (option.value == "") {
                        option.hidden = false;
                        return;
                    }

                    option.hidden = option.dataset.bidang != bidangId;

                });

                jabatan.value = "";

            });
        </script>
    @endpush

@endsection
