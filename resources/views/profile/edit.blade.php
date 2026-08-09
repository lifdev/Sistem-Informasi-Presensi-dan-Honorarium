@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-3xl space-y-6">

        <!-- Info Akun -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-slate-900 dark:ring-slate-700">
            <div class="border-b border-gray-200 px-6 py-4 dark:border-slate-700">
                <h2 class="flex items-center text-lg font-semibold text-gray-800 dark:text-white">
                    <i class="bi bi-person-circle mr-2 text-blue-600 dark:text-blue-400"></i>
                    Informasi Akun
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Nama (read only, tidak bisa diubah sendiri) -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Nama Lengkap
                        </label>
                        <input type="text" value="{{ $user->name }}" disabled
                            class="w-full cursor-not-allowed rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-gray-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400">
                        <p class="mt-1 text-xs text-slate-500">Nama tidak dapat diubah sendiri. Hubungi admin jika perlu diubah.</p>
                    </div>

                    <!-- Email -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('email') border-red-500 @enderror">
                        @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role (read only) -->
                    <div class="mb-6">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Role
                        </label>
                        <input type="text" value="{{ ucfirst($user->role) }}" disabled
                            class="w-full cursor-not-allowed rounded-lg border border-gray-300 bg-gray-100 px-4 py-2.5 text-gray-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-400">
                        <p class="mt-1 text-xs text-slate-500">Role tidak dapat diubah sendiri. Hubungi admin jika perlu diubah.</p>
                    </div>

                    <hr class="my-6 border-gray-200 dark:border-slate-700">

                    <h3 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-500">
                        Ubah Password (opsional)
                    </h3>

                    <!-- Password saat ini -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                            Password Saat Ini
                        </label>
                        <input type="password" name="current_password" autocomplete="current-password"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('current_password') border-red-500 @enderror"
                            placeholder="Isi hanya jika ingin mengubah password">
                        @error('current_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password baru & konfirmasi -->
                    <div class="mb-6 grid gap-5 md:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Password Baru
                            </label>
                            <input type="password" name="password" autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white @error('password') border-red-500 @enderror"
                                placeholder="Minimal 8 karakter">
                            @error('password')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-gray-700 dark:text-slate-300">
                                Konfirmasi Password Baru
                            </label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-gray-800 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full rounded-lg bg-blue-600 px-4 py-3 font-semibold text-white transition hover:bg-blue-700">
                        Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection