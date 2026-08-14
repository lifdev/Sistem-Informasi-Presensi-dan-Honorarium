@extends('layouts.app')

@section('title', 'Pengaturan Honorarium')

@section('content')
<div class="mx-auto max-w-7xl">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Pengaturan Honorarium
            </h1>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Kelola honorarium tiap jabatan. Pilih <span class="font-medium">Bulanan</span> untuk karyawan tetap
                (flat per bulan, potongan alpha dihitung otomatis) atau <span class="font-medium">Per Hari Hadir</span>
                (dibayar sesuai jumlah hari hadir, tanpa potongan alpha).
                Bonus tidak diatur di sini &mdash; bonus bersifat tidak rutin dan diinput langsung per karyawan
                di halaman <span class="font-medium">Detail Honorarium</span> tiap bulan.
            </p>
        </div>
    </div>

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

            <form action="{{ route('admin.pengaturan.honorarium.update', $item) }}" method="POST" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                        Tipe Honorarium
                    </label>

                    <div class="grid grid-cols-2 gap-3">
                        <label
                            class="tipe-option cursor-pointer rounded-xl border px-4 py-3 text-sm font-medium transition
                                    {{ old('tipe', $item->tipe) === 'bulanan' ? 'border-blue-500 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'border-slate-300 text-slate-600 dark:border-slate-700 dark:text-slate-300' }}">
                            <input
                                type="radio"
                                name="tipe"
                                value="bulanan"
                                class="tipe-radio mr-2"
                                data-target="bulanan-{{ $item->id }}"
                                onchange="toggleTipeHonorarium('{{ $item->id }}', 'bulanan')"
                                {{ old('tipe', $item->tipe) === 'bulanan' ? 'checked' : '' }}>
                            Bulanan
                        </label>

                        <label
                            class="tipe-option cursor-pointer rounded-xl border px-4 py-3 text-sm font-medium transition
                                    {{ old('tipe', $item->tipe) === 'per_hadir' ? 'border-blue-500 bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'border-slate-300 text-slate-600 dark:border-slate-700 dark:text-slate-300' }}">
                            <input
                                type="radio"
                                name="tipe"
                                value="per_hadir"
                                class="tipe-radio mr-2"
                                data-target="per_hadir-{{ $item->id }}"
                                onchange="toggleTipeHonorarium('{{ $item->id }}', 'per_hadir')"
                                {{ old('tipe', $item->tipe) === 'per_hadir' ? 'checked' : '' }}>
                            Per Hari Hadir
                        </label>
                    </div>

                    @error('tipe')
                    <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div id="bulanan-{{ $item->id }}" class="space-y-6" style="{{ old('tipe', $item->tipe) === 'bulanan' ? '' : 'display:none' }}">
                    <div>
                        <label for="honorarium_pokok_{{ $item->id }}" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Honorarium Pokok (per bulan)
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input
                                type="number"
                                id="honorarium_pokok_{{ $item->id }}"
                                name="honorarium_pokok"
                                value="{{ old('honorarium_pokok', $item->honorarium_pokok) }}"
                                min="0"
                                step="1000"
                                class="w-full rounded-xl border bg-white py-3 pl-12 pr-4 outline-none transition focus:ring-2 dark:bg-slate-800
                                        {{ $errors->has('honorarium_pokok') ? 'border-red-400 focus:border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-200 dark:border-slate-700' }}">
                        </div>

                        @error('honorarium_pokok')
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
                                Dihitung otomatis dari honorarium pokok &divide; jumlah hari kerja bulan berjalan. Diperbarui saat honorarium pokok disimpan.
                            </p>
                        </div>
                    </div>
                </div>

                <div id="per_hadir-{{ $item->id }}" class="space-y-6" style="{{ old('tipe', $item->tipe) === 'per_hadir' ? '' : 'display:none' }}">
                    <div>
                        <label for="tarif_per_hadir_{{ $item->id }}" class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Tarif per Hari Hadir
                        </label>

                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">Rp</span>
                            <input
                                type="number"
                                id="tarif_per_hadir_{{ $item->id }}"
                                name="tarif_per_hadir"
                                value="{{ old('tarif_per_hadir', $item->tarif_per_hadir) }}"
                                min="0"
                                step="1000"
                                class="w-full rounded-xl border bg-white py-3 pl-12 pr-4 outline-none transition focus:ring-2 dark:bg-slate-800
                                        {{ $errors->has('tarif_per_hadir') ? 'border-red-400 focus:border-red-500 focus:ring-red-200' : 'border-slate-300 focus:border-blue-500 focus:ring-blue-200 dark:border-slate-700' }}">
                        </div>

                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400">
                            Honorarium bulan berjalan = tarif ini &times; jumlah hari hadir. Tidak ada potongan alpha &mdash;
                            hari tidak hadir otomatis tidak dibayar.
                        </p>

                        @error('tarif_per_hadir')
                        <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
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
                Pengaturan honorarium belum tersedia.
            </p>
        </div>
        @endforelse
    </div>

</div>

<script>
    function toggleTipeHonorarium(itemId, tipe) {
        const bulanan = document.getElementById('bulanan-' + itemId);
        const perHadir = document.getElementById('per_hadir-' + itemId);

        if (bulanan) bulanan.style.display = tipe === 'bulanan' ? '' : 'none';
        if (perHadir) perHadir.style.display = tipe === 'per_hadir' ? '' : 'none';

        document
            .querySelectorAll(`input.tipe-radio[data-target^="bulanan-${itemId}"], input.tipe-radio[data-target^="per_hadir-${itemId}"]`)
            .forEach((radio) => {
                const label = radio.closest('.tipe-option');
                if (!label) return;
                const isActive = radio.value === tipe;
                label.classList.toggle('border-blue-500', isActive);
                label.classList.toggle('bg-blue-50', isActive);
                label.classList.toggle('text-blue-700', isActive);
                label.classList.toggle('border-slate-300', !isActive);
                label.classList.toggle('text-slate-600', !isActive);
            });
    }
</script>
@endsection