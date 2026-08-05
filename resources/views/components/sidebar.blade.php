<aside class="fixed left-0 top-0 z-40 h-screen w-72 bg-slate-900 text-white shadow-xl border-r border-white/10">

    {{-- Logo --}}
    <div class=" flex h-20 items-center border-b border-slate-800 px-4">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-600 text-xl font-bold">
                E
            </div>
            <div>
                <h1 class="text-lg font-bold tracking-wide">
                    e-SIPH
                </h1>
            </div>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="space-y-1 p-4 overflow-y-auto h-[calc(100vh-80px)]">

        <p class="px-4 pt-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
            Menu Utama
        </p>

        @if (auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h7v7H3V3zm11 0h7v5h-7V3zM3 14h7v7H3v-7zm11-3h7v10h-7V11z" />
                </svg>
                <span>
                    Dashboard
                </span>
            </a>

            <p class="px-4 pt-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Master Data
            </p>

            <a href="{{ route('admin.karyawan.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.karyawan.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 7a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                </svg>

                <span>
                    Karyawan
                </span>
            </a>

            <a href="{{ route('admin.bidang.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.bidang.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M11 12a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                    <path d="M16.616 13.924a5 5 0 1 0 -9.23 0" />
                    <path d="M20.307 15.469a9 9 0 1 0 -16.615 0" />
                    <path d="M9 21l3 -9l3 9" />
                    <path d="M10 19h4" />
                </svg>

                <span>
                    Bidang
                </span>
            </a>

            <a href="{{ route('admin.jabatan.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.jabatan.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 9a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9" />
                    <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                </svg>
                <span>Jabatan</span>
            </a>

            <p class="px-4 pt-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Kehadiran
            </p>

            <a href="{{ route('admin.presensi.rekap') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.presensi.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M9 12l2 2l4 -4" />
                </svg>
                <span>Presensi</span>
            </a>

            <a href="{{ route('admin.izin.approval') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.izin.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                    <path d="M9 9l1 0" />
                    <path d="M9 13l6 0" />
                    <path d="M9 17l6 0" />
                </svg>
                <span>Izin</span>
            </a>

            <p class="px-4 pt-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Honorarium
            </p>

            <a href="{{ route('admin.honorarium.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.honorarium.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                    <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                </svg>
                <span>Honorarium</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.laporan.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 21h-7a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v8" />
                    <path d="M3 10h18" />
                    <path d="M10 3v18" />
                    <path d="M19 22v-6" />
                    <path d="M22 19l-3 -3l-3 3" />
                </svg>
                <span>Laporan</span>
            </a>

            <p class="px-4 pt-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
                Pengaturan
            </p>

            <a href="{{ route('admin.pengaturan.gaji') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.pengaturan.gaji*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M7 15h-3a1 1 0 0 1 -1 -1v-8a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v3" />
                    <path d="M7 10a1 1 0 0 1 1 -1h12a1 1 0 0 1 1 1v8a1 1 0 0 1 -1 1h-12a1 1 0 0 1 -1 -1l0 -8" />
                    <path d="M12 14a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                </svg>
                <span>Pengaturan Gaji</span>
            </a>

            <a href="{{ route('admin.pengaturan.lokasi') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.pengaturan.lokasi*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 11a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0" />
                </svg>
                <span>Pengaturan Lokasi</span>
            </a>

            <a href="{{ route('admin.pengaturan.jam') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('admin.pengaturan.jam*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                    <path d="M12 7v5l3 3" />
                </svg>
                <span>Pengaturan Jam</span>
            </a>
        @elseif(auth()->user()->isPimpinan())
            <a href="{{ route('pimpinan.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('pimpinan.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h7v7H3V3zm11 0h7v5h-7V3zM3 14h7v7H3v-7zm11-3h7v10h-7V11z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('pimpinan.izin.approval') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('pimpinan.izin.approval') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                    <path d="M9 9l1 0" />
                    <path d="M9 13l6 0" />
                    <path d="M9 17l6 0" />
                </svg>
                <span>Approval Izin</span>
            </a>

            <a href="{{ route('pimpinan.presensi.rekap') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('pimpinan.presensi.rekap') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M9 12l2 2l4 -4" />
                </svg>
                <span>Rekap Presensi</span>
            </a>

            <a href="{{ route('pimpinan.honorarium.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('pimpinan.honorarium.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                    <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                </svg>
                <span>Honorarium</span>
            </a>
        @elseif(auth()->user()->isKaryawan())
            <a href="{{ route('karyawan.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('karyawan.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 3h7v7H3V3zm11 0h7v5h-7V3zM3 14h7v7H3v-7zm11-3h7v10h-7V11z" />
                </svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('karyawan.presensi.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('karyawan.presensi.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" />
                    <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" />
                    <path d="M12 11v2a14 14 0 0 0 2.5 8" />
                    <path d="M8 15a18 18 0 0 0 1.8 6" />
                    <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" />
                </svg>
                <span>Absen</span>
            </a>

            <a href="{{ route('karyawan.presensi.riwayat') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('karyawan.presensi.riwayat') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 8l0 4l2 2" />
                    <path d="M3.05 11a9 9 0 1 1 .5 4m-.5 5v-5h5" />
                </svg>
                <span>Riwayat Presensi</span>
            </a>

            <a href="{{ route('karyawan.izin.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('karyawan.izin.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                    <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2" />
                    <path d="M9 9l1 0" />
                    <path d="M9 13l6 0" />
                    <path d="M9 17l6 0" />
                </svg>
                <span>Izin</span>
            </a>

            <a href="{{ route('karyawan.honorarium.index') }}"
                class="flex items-center gap-3 rounded-lg px-4 py-3 transition {{ request()->routeIs('karyawan.honorarium.index') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M17 8v-3a1 1 0 0 0 -1 -1h-10a2 2 0 0 0 0 4h12a1 1 0 0 1 1 1v3m0 4v3a1 1 0 0 1 -1 1h-12a2 2 0 0 1 -2 -2v-12" />
                    <path d="M20 12v4h-4a2 2 0 0 1 0 -4h4" />
                </svg>
                <span>Honorarium</span>
            </a>
        @endif

        <p class="px-4 pt-2 pb-2 text-xs font-semibold uppercase tracking-wider text-slate-500">
            System
        </p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-4 py-3 transition text-red-500 hover:bg-red-900/20 hover:text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                    <path d="M7 12h14l-3 -3m0 6l3 -3" />
                </svg>
                <span>Logout</span>
            </button>
        </form>
    </nav>
</aside>
