@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 dark:text-white">Data Pengguna</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Kelola akun login dan data karyawan dalam satu tempat.</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row">
            <form action="{{ route('admin.pengguna.index') }}" method="GET">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, NIP, role..."
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-500 sm:w-80 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
            </form>
            <a href="{{ route('admin.pengguna.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-blue-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-blue-700">
                <span class="text-lg leading-none">+</span>
                Tambah Pengguna
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-slate-100 dark:bg-slate-700">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-600 dark:text-slate-300">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4">Data Karyawan</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse($pengguna as $user)
                    @php
                    $roleClass = match ($user->role) {
                    'admin' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                    'pimpinan' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                    default => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300',
                    };
                    @endphp
                    <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-700/40">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $pengguna->firstItem() + $loop->index }}</td>
                        <td class="px-6 py-4 font-semibold text-slate-800 dark:text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $user->email }}</td>
                        <td class="px-6 py-4"><span class="rounded-full px-3 py-1 text-xs font-semibold {{ $roleClass }}">{{ ucfirst($user->role) }}</span></td>
                        <td class="px-6 py-4 text-sm">
                            @if($user->karyawan)
                            <div class="font-medium text-slate-800 dark:text-white">{{ $user->karyawan->nip }}</div>
                            <div class="text-slate-500">{{ $user->karyawan->jabatan?->nama ?? '-' }}</div>
                            @else
                            <span class="text-slate-400">Tidak terkait karyawan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($user->karyawan)
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $user->karyawan->status === 'aktif' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-300' }}">
                                {{ ucfirst($user->karyawan->status) }}
                            </span>
                            @else
                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600 dark:bg-slate-700 dark:text-slate-300">Akun aktif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.pengguna.edit', $user) }}" class="rounded-lg bg-amber-500 p-2 text-white transition hover:bg-amber-600" title="Edit">Edit</a>
                                <form action="{{ route('admin.pengguna.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna {{ addslashes($user->name) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="rounded-lg bg-red-600 px-3 py-2 text-sm text-white transition hover:bg-red-700">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada pengguna.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pengguna->hasPages())
        <div class="border-t border-slate-200 px-6 py-4 dark:border-slate-700">{{ $pengguna->links() }}</div>
        @endif
    </div>
</div>
@endsection