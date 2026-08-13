@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div>
        <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Tambah Pengguna</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Buat akun login. Data karyawan hanya dibuat jika role yang dipilih adalah Karyawan.</p>
    </div>

    @if(session('error'))<div class="rounded-xl bg-red-100 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="rounded-xl bg-red-100 px-4 py-3 text-sm text-red-700">
        <ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>@endif

    <form action="{{ route('admin.pengguna.store') }}" method="POST" class="space-y-8">
        @csrf
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Akun Login</h3>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div><label class="mb-2 block text-sm font-medium">Nama</label><input name="nama" value="{{ old('nama') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                <div><label class="mb-2 block text-sm font-medium">Email</label><input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                <div><label class="mb-2 block text-sm font-medium">Password</label><input type="password" name="password" required minlength="6" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                <div><label class="mb-2 block text-sm font-medium">Role</label><select id="role" name="role" required class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">
                        <option value="karyawan" {{ old('role', 'karyawan') === 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                        <option value="pimpinan" {{ old('role') === 'pimpinan' ? 'selected' : '' }}>Pimpinan</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select></div>
            </div>
        </div>

        <div id="karyawan-fields" class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <h3 class="text-lg font-semibold text-slate-800 dark:text-white">Data Karyawan</h3>
            <p class="mt-1 text-sm text-slate-500">Bagian ini hanya diperlukan untuk pengguna dengan role Karyawan.</p>
            <div class="mt-5 grid gap-5 md:grid-cols-2">
                <div><label class="mb-2 block text-sm font-medium">NIP</label><input name="nip" value="{{ old('nip') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                <div><label class="mb-2 block text-sm font-medium">Jabatan</label><select name="jabatan_id" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">
                        <option value="">Pilih Jabatan</option>@foreach($jabatans as $jabatan)<option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama }}</option>@endforeach
                    </select></div>
                <div><label class="mb-2 block text-sm font-medium">Jenis Kelamin</label><select name="jenis_kelamin" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select></div>
                <div><label class="mb-2 block text-sm font-medium">Tanggal Masuk</label><input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                <div><label class="mb-2 block text-sm font-medium">No HP</label><input name="no_hp" value="{{ old('no_hp') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                <div><label class="mb-2 block text-sm font-medium">Alamat</label><textarea name="alamat" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">{{ old('alamat') }}</textarea></div>
            </div>

            <div class="mt-6 border-t border-slate-200 pt-6 dark:border-slate-700">
                <label class="flex items-center gap-3 text-sm font-medium"><input type="checkbox" name="gunakan_honorarium_khusus" value="1" {{ old('gunakan_honorarium_khusus') ? 'checked' : '' }} onchange="toggleHonorarium()"> Gunakan pengaturan honorarium khusus</label>
                <div id="honorarium-fields" class="mt-4 grid gap-5 md:grid-cols-3 {{ old('gunakan_honorarium_khusus') ? '' : 'hidden' }}">
                    <div><label class="mb-2 block text-sm font-medium">Tipe Honorarium</label><select name="honorarium_tipe" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900">
                            <option value="">Pilih</option>
                            <option value="bulanan" {{ old('honorarium_tipe') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="per_hadir" {{ old('honorarium_tipe') === 'per_hadir' ? 'selected' : '' }}>Per Hadir</option>
                        </select></div>
                    <div><label class="mb-2 block text-sm font-medium">Honorarium Pokok</label><input type="number" step="0.01" min="0" name="honorarium_pokok" value="{{ old('honorarium_pokok') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                    <div><label class="mb-2 block text-sm font-medium">Tarif Per Hadir</label><input type="number" step="0.01" min="0" name="tarif_per_hadir" value="{{ old('tarif_per_hadir') }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-600 dark:bg-slate-900"></div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3"><a href="{{ route('admin.pengguna.index') }}" class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium">Batal</a><button class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white hover:bg-blue-700">Simpan Pengguna</button></div>
    </form>
</div>
<script>
    function toggleKaryawanFields() {
        const isKaryawan = document.getElementById('role').value === 'karyawan';
        document.getElementById('karyawan-fields').classList.toggle('hidden', !isKaryawan);
    }

    function toggleHonorarium() {
        const checkbox = document.querySelector('[name="gunakan_honorarium_khusus"]');
        document.getElementById('honorarium-fields').classList.toggle('hidden', !checkbox.checked);
    }
    document.getElementById('role').addEventListener('change', toggleKaryawanFields);
    toggleKaryawanFields();
</script>
@endsection