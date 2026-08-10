<header
    class="sticky top-0 z-30 flex h-20 items-center justify-between gap-3 border-b border-slate-200 bg-white px-4 dark:border-slate-800 dark:bg-slate-900 sm:px-6 lg:px-8">

    {{-- Kiri --}}
    <div class="flex min-w-0 items-center gap-3 sm:gap-4">

        {{-- Tombol buka sidebar (mobile only) --}}
        <button id="sidebarToggle" type="button"
            class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:hover:bg-slate-700 lg:hidden"
            aria-label="Buka menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <div class="min-w-0">
            <h1 class="truncate text-lg font-semibold text-slate-800 dark:text-white sm:text-xl">
                @yield('title', 'Dashboard')
            </h1>
            <p class="mt-1 hidden text-sm text-slate-500 dark:text-slate-400 sm:block">
                Sistem Informasi Presensi dan Honorarium
            </p>
        </div>
    </div>

    {{-- Kanan --}}
    <div class="flex flex-shrink-0 items-center gap-2 sm:gap-4">

        {{-- Dark Mode --}}
        <button id="theme-toggle" onclick="toggleDarkMode()"
            class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-lg border border-slate-300 bg-white text-slate-700 transition hover:bg-slate-100 dark:border-slate-700 dark:bg-slate-800 dark:text-yellow-400 dark:hover:bg-slate-700">

            {{-- Moon --}}
            <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 dark:hidden" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.598.748-3.752A9.753 9.753 0 003 12c0 5.385 4.365 9.75 9.75 9.75a9.753 9.753 0 009.002-6.748z" />
            </svg>

            {{-- Sun --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hidden h-5 w-5 dark:block" id="icon-sun">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 3v2.25M12 18.75V21M4.22 4.22l1.59 1.59M18.19 18.19l1.59 1.59M3 12h2.25M18.75 12H21M4.22 19.78l1.59-1.59M18.19 5.81l1.59-1.59M12 16.5a4.5 4.5 0 100-9 4.5 4.5 0 000 9z" />
            </svg>
        </button>

        {{-- User --}}
        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 rounded-lg transition hover:opacity-80">
            <div class="hidden text-right sm:block">
                <p class="font-semibold text-slate-800 dark:text-white">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-sm text-slate-500">
                    {{ ucfirst(auth()->user()->role) }}
                </p>
            </div>
            <div
                class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full bg-blue-600 font-bold text-white">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </a>
    </div>
</header>