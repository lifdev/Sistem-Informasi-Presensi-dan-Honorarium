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

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Role Akun
                        </label>

                        @if ($karyawan->user && $karyawan->user->id === auth()->id())
                        <select disabled
                            class="w-full cursor-not-allowed rounded-xl border border-slate-300 bg-slate-100 px-4 py-3 text-slate-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-400">
                            <option>{{ ucfirst($karyawan->user->role) }}</option>
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Anda tidak dapat mengubah role akun Anda sendiri.</p>
                        @elseif ($karyawan->user)
                        <select name="role"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">

                            <option value="admin" {{ old('role', $karyawan->user->role) == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>

                            <option value="pimpinan" {{ old('role', $karyawan->user->role) == 'pimpinan' ? 'selected' : '' }}>
                                Pimpinan
                            </option>

                            <option value="karyawan" {{ old('role', $karyawan->user->role) == 'karyawan' ? 'selected' : '' }}>
                                Karyawan
                            </option>

                        </select>
                        @else
                        <p class="mt-1 text-sm text-slate-500">Karyawan ini belum memiliki akun login.</p>
                        @endif

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Alamat
                        </label>

                        <textarea name="alamat" rows="3"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">{{ old('alamat', $karyawan->alamat) }}</textarea>

                    </div>

                </div>

            </div>


            {{-- Pengaturan Honorarium Individu --}}
            @php
            $honorKhususAktif = old('gunakan_honorarium_khusus', !is_null($karyawan->honorarium_tipe));
            $honorTipe = old('honorarium_tipe', $karyawan->honorarium_tipe);
            @endphp
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-5 dark:border-slate-700 dark:bg-slate-800/50">
                <div class="mb-5">
                    <h3 class="text-lg font-semibold text-slate-800 dark:text-white">
                        Pengaturan Honorarium Individu
                    </h3>
                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        Jika tidak memakai pengaturan khusus, karyawan mengikuti pengaturan honorarium jabatannya.
                        Gunakan pengaturan khusus jika tarif atau tipe karyawan ini berbeda dari jabatan yang sama.
                    </p>
                </div>

                <label class="flex cursor-pointer items-start gap-3">
                    <input type="checkbox" name="gunakan_honorarium_khusus" value="1"
                        id="gunakan_honorarium_khusus"
                        class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                        {{ $honorKhususAktif ? 'checked' : '' }}
                        onchange="toggleHonorariumKhusus()">
                    <span>
                        <span class="block text-sm font-medium text-slate-700 dark:text-slate-200">Gunakan pengaturan khusus untuk karyawan ini</span>
                        <span class="block text-xs text-slate-500 dark:text-slate-400">Matikan untuk kembali mengikuti pengaturan jabatan.</span>
                    </span>
                </label>

                <div id="pengaturan-honorarium-khusus" class="mt-5 space-y-5 {{ $honorKhususAktif ? '' : 'hidden' }}">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Tipe Honorarium</label>
                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-300 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
                                <input type="radio" name="honorarium_tipe" value="bulanan" class="mt-1"
                                    onchange="toggleHonorariumKhususFields()"
                                    {{ $honorTipe === 'bulanan' ? 'checked' : '' }}>
                                <span>
                                    <span class="block text-sm font-medium text-slate-700 dark:text-slate-200">Bulanan</span>
                                    <span class="block text-xs text-slate-500">Honor pokok per bulan.</span>
                                </span>
                            </label>
                            <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-300 bg-white p-4 dark:border-slate-700 dark:bg-slate-900">
                                <input type="radio" name="honorarium_tipe" value="per_hadir" class="mt-1"
                                    onchange="toggleHonorariumKhususFields()"
                                    {{ $honorTipe === 'per_hadir' ? 'checked' : '' }}>
                                <span>
                                    <span class="block text-sm font-medium text-slate-700 dark:text-slate-200">Per Hari Hadir</span>
                                    <span class="block text-xs text-slate-500">Hanya dibayar berdasarkan presensi hadir.</span>
                                </span>
                            </label>
                        </div>
                        @error('honorarium_tipe') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div id="honorarium-khusus-bulanan" class="{{ $honorTipe === 'bulanan' ? '' : 'hidden' }}">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Honorarium Pokok</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input type="number" name="honorarium_pokok" value="{{ old('honorarium_pokok', $karyawan->honorarium_pokok) }}" min="0" step="1000"
                                class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        @error('honorarium_pokok') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div id="honorarium-khusus-per-hadir" class="{{ $honorTipe === 'per_hadir' ? '' : 'hidden' }}">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Tarif per Hari Hadir</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input type="number" name="tarif_per_hadir" value="{{ old('tarif_per_hadir', $karyawan->tarif_per_hadir) }}" min="0" step="1000"
                                class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-12 pr-4 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-900">
                        </div>
                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">Tidak ada alpha otomatis untuk tipe ini.</p>
                        @error('tarif_per_hadir') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>
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
    function toggleHonorariumKhusus() {
        const checkbox = document.getElementById('gunakan_honorarium_khusus');
        const panel = document.getElementById('pengaturan-honorarium-khusus');
        if (panel) panel.classList.toggle('hidden', !checkbox?.checked);
        if (!checkbox?.checked) {
            document.querySelectorAll('input[name="honorarium_tipe"]').forEach(el => el.checked = false);
            document.getElementById('honorarium-khusus-bulanan')?.classList.add('hidden');
            document.getElementById('honorarium-khusus-per-hadir')?.classList.add('hidden');
        }
    }

    function toggleHonorariumKhususFields() {
        const tipe = document.querySelector('input[name="honorarium_tipe"]:checked')?.value;
        document.getElementById('honorarium-khusus-bulanan')?.classList.toggle('hidden', tipe !== 'bulanan');
        document.getElementById('honorarium-khusus-per-hadir')?.classList.toggle('hidden', tipe !== 'per_hadir');
    }

    toggleHonorariumKhususFields();

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