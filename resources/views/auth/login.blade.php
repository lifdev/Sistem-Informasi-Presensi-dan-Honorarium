<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Presensi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-slate-100 p-4 sm:p-6 font-sans">
    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col md:flex-row">

        <!-- ===================== FORM ===================== -->
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center">

            <!-- Heading -->
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight">
                Selamat Datang
            </h1>
            <p class="text-slate-500 mt-3 mb-8">
                Silakan masuk untuk melanjutkan ke Sistem Informasi Presensi & Honorarium
            </p>

            {{-- Alert sukses --}}
            @if (session('success'))
                <div
                    class="flex items-start gap-2 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3 mb-4">
                    <svg class="w-4 h-4 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Alert error --}}
            @if ($errors->any())
                <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 mb-4">
                    <div class="flex items-start gap-2">
                        <svg class="w-4 h-4 mt-0.5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm0-11a1 1 0 011 1v4a1 1 0 11-2 0V8a1 1 0 011-1zm0 8a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-5">

                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Email
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com"
                        required autofocus
                        class="w-full h-12 px-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password" placeholder="Masukkan password" required
                            class="w-full h-12 px-4 pr-12 rounded-xl border border-slate-200 bg-slate-50 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition">
                        <span onclick="togglePassword()"
                            class="toggle-password absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600 cursor-pointer">
                            <svg id="eyeIcon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-slate-300 text-violet-600 focus:ring-violet-600">
                        <span class="text-sm text-slate-600">Ingat saya</span>
                    </label>

                    <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer"
                        class="flex items-center gap-1.5 text-sm text-slate-600 hover:text-blue-400 transition">
                        <svg class="w-4 h-4 text-green-500" viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.46 1.32 4.96L2 22l5.25-1.38a9.9 9.9 0 004.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.86 9.86 0 0012.04 2zm0 18.13a8.2 8.2 0 01-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.2 8.2 0 01-1.26-4.36c0-4.54 3.7-8.24 8.25-8.24 2.2 0 4.27.86 5.83 2.42a8.18 8.18 0 012.41 5.83c0 4.55-3.7 8.21-8.25 8.21zm4.52-6.16c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.24-.64.8-.78.97-.14.16-.29.18-.53.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.23-1.46-1.37-1.7-.14-.25-.02-.38.11-.5.11-.11.25-.29.37-.43.12-.15.16-.25.24-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.77-1.85-.2-.48-.4-.42-.56-.42-.14-.01-.31-.01-.47-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.23.89 2.41 1.02 2.58.12.16 1.75 2.67 4.24 3.74.59.26 1.05.41 1.41.53.59.19 1.13.16 1.55.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.15-1.18-.07-.11-.23-.17-.48-.29z" />
                        </svg>
                        <span>Butuh bantuan?</span>
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full h-12 rounded-xl bg-blue-600 hover:bg-blue-400 text-white font-semibold flex items-center justify-center gap-2 transition hover:-translate-y-0.5 shadow-lg shadow-violet-600/20">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H3" />
                    </svg>
                    Masuk
                </button>

            </form>

            <p class="text-center text-xs text-slate-400 mt-10">
                &copy; {{ date('Y') }} Sistem Informasi Presensi & Honorarium
            </p>

        </div>

        <!-- ===================== ILLUSTRATION ===================== -->
        <div
            class="hidden md:flex w-full md:w-1/2 relative bg-gradient-to-br from-indigo-400 via-blue-500 to-purple-600 items-center justify-center overflow-hidden">

            <!-- Clouds -->
            <svg class="absolute top-8 left-6 w-24 opacity-90" viewBox="0 0 100 60" fill="white">
                <ellipse cx="30" cy="35" rx="30" ry="20" />
                <ellipse cx="55" cy="25" rx="22" ry="18" />
                <ellipse cx="70" cy="38" rx="18" ry="14" />
            </svg>
            <svg class="absolute top-4 right-10 w-32 opacity-90" viewBox="0 0 100 60" fill="white">
                <ellipse cx="30" cy="35" rx="30" ry="20" />
                <ellipse cx="55" cy="25" rx="22" ry="18" />
                <ellipse cx="70" cy="38" rx="18" ry="14" />
            </svg>
            <svg class="absolute bottom-10 left-4 w-28 opacity-90" viewBox="0 0 100 60" fill="white">
                <ellipse cx="30" cy="35" rx="30" ry="20" />
                <ellipse cx="55" cy="25" rx="22" ry="18" />
                <ellipse cx="70" cy="38" rx="18" ry="14" />
            </svg>
            <svg class="absolute bottom-16 right-6 w-20 opacity-90" viewBox="0 0 100 60" fill="white">
                <ellipse cx="30" cy="35" rx="30" ry="20" />
                <ellipse cx="55" cy="25" rx="22" ry="18" />
                <ellipse cx="70" cy="38" rx="18" ry="14" />
            </svg>

            <!-- Padlock -->
            <svg class="absolute right-10 top-1/2 -translate-y-1/2 w-16 h-16 drop-shadow-xl" viewBox="0 0 64 64"
                fill="none">
                <rect x="14" y="28" width="36" height="28" rx="6" fill="white" />
                <path d="M22 28V20a10 10 0 0 1 20 0v8" stroke="white" stroke-width="5" fill="none" />
                <circle cx="32" cy="40" r="4" fill="#3a76ed" />
                <rect x="30" y="42" width="4" height="8" rx="2" fill="#145efe" />
            </svg>

            <!-- Speech bubble check -->
            <svg class="absolute left-10 top-1/3 w-16 h-14 drop-shadow-xl" viewBox="0 0 80 64" fill="none">
                <path d="M4 8h72a4 4 0 0 1 4 4v30a4 4 0 0 1-4 4H30l-14 14V46H4a4 4 0 0 1-4-4V12a4 4 0 0 1 4-4z"
                    fill="white" />
                <path d="M22 26l8 8 16-16" stroke="#2864f0" stroke-width="4" stroke-linecap="round"
                    stroke-linejoin="round" fill="none" />
            </svg>

            <!-- Phone with fingerprint -->
            <svg class="relative w-56 drop-shadow-2xl" viewBox="0 0 200 380" fill="none">
                <rect x="4" y="4" width="192" height="372" rx="28" fill="#1e1b4b" />
                <rect x="14" y="16" width="172" height="348" rx="18" fill="url(#screenGradient)" />
                <defs>
                    <linearGradient id="screenGradient" x1="0" y1="0" x2="200" y2="380"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#003fd2" />
                        <stop offset="1" stop-color="#0062ff" />
                    </linearGradient>
                </defs>
                <circle cx="100" cy="150" r="46" stroke="white" stroke-opacity="0.85" stroke-width="3"
                    fill="none" />
                <path
                    d="M100 118c17 0 30 13 30 30v14M100 118c-17 0-30 13-30 30v20M78 150v10a22 22 0 0 0 22 22M122 150v6a22 22 0 0 1-8 17"
                    stroke="white" stroke-width="3" stroke-linecap="round" fill="none" />
                <rect x="60" y="230" width="80" height="6" rx="3" fill="white"
                    fill-opacity="0.5" />
                <rect x="60" y="230" width="50" height="6" rx="3" fill="white" />
            </svg>
        </div>

    </div>

    <script>
        function togglePassword() {

            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');

            if (input.type === "password") {

                input.type = "text";
                // ganti ke ikon "mata dicoret"
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />';

            } else {

                input.type = "password";
                // ganti kembali ke ikon "mata"
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';

            }

        }
    </script>

</body>

</html>
