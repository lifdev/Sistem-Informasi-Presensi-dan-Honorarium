@extends('layouts.app')

@section('title', 'Presensi Hari Ini')
@section('page-title', 'Presensi Hari Ini')

@section('content')
<div class="flex justify-center">
    <div class="w-full max-w-2xl">

        {{-- Info Tanggal --}}
        <div
            class="mb-4 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
            <div class="flex items-center justify-between p-5">
                <div>
                    <div class="text-sm text-slate-500 dark:text-slate-400">Hari ini</div>
                    <div class="text-lg font-bold text-slate-800 dark:text-white">
                        {{ $today->translatedFormat('l, d F Y') }}
                    </div>
                </div>

                <div class="text-right">
                    <div class="text-sm text-slate-500 dark:text-slate-400">Jam</div>
                    <div class="text-lg font-bold text-slate-800 dark:text-white" id="jam-sekarang">
                        --:--:--
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Absen --}}
        <div
            class="mb-4 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
            <div
                class="flex items-center gap-2 border-b border-slate-200 px-5 py-4 font-semibold text-slate-800 dark:border-slate-700 dark:text-white">
                <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6l2 2 4-4" />
                </svg>
                Status Absen
            </div>

            <div class="p-5">
                <div class="grid grid-cols-1 gap-3 text-center">

                    {{-- Masuk --}}
                    <div>
                        <div
                            class="rounded-xl p-4
                            {{ $presensi && $presensi->jam_masuk
                                ? 'border border-green-400 bg-green-50 dark:border-green-700 dark:bg-green-900/30'
                                : 'bg-slate-50 dark:bg-slate-800' }}">

                            <svg class="mx-auto h-8 w-8 {{ $presensi && $presensi->jam_masuk ? 'text-green-600 dark:text-green-400' : 'text-slate-400 dark:text-slate-500' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 9l3 3m0 0l-3 3m3-3H3m6.75-9H18a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0118 21H9.75" />
                            </svg>

                            <div class="mt-1 font-semibold text-slate-800 dark:text-white">
                                Masuk
                            </div>

                            <div
                                class="text-lg font-bold
                                {{ $presensi && $presensi->jam_masuk
                                    ? 'text-green-600 dark:text-green-400'
                                    : 'text-slate-400 dark:text-slate-500' }}">
                                {{ $presensi && $presensi->jam_masuk ? $presensi->jam_masuk : '--:--' }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Peta GPS --}}
        <div
            class="mb-4 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
            <div
                class="flex items-center justify-between border-b border-slate-200 px-5 py-4 font-semibold text-slate-800 dark:border-slate-700 dark:text-white">
                <span class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Lokasi GPS
                </span>

                <span id="status-gps"
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    Mendeteksi lokasi...
                </span>
            </div>

            <div class="p-5">
                <div id="map" class="mb-2 h-[280px] w-full rounded-xl bg-slate-100 dark:bg-slate-800">
                </div>

                <div class="mt-2 flex justify-between text-sm text-slate-500 dark:text-slate-400">
                    <span>Lat: <span id="lat-val">-</span></span>
                    <span>Lng: <span id="lng-val">-</span></span>
                    <span>Jarak: <span id="jarak-val">-</span> meter</span>
                </div>
            </div>
        </div>

        {{-- Kamera Selfie --}}
        @if (!$presensi || !$presensi->jam_masuk)
        <div
            class="mb-4 overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-700">
            <div
                class="flex items-center justify-between border-b border-slate-200 px-5 py-4 font-semibold text-slate-800 dark:border-slate-700 dark:text-white">
                <span class="flex items-center gap-2">
                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.113-1.132.178C3.046 7.6 2.25 8.507 2.25 9.574v9.176c0 1.24 1.01 2.25 2.25 2.25h15c1.24 0 2.25-1.01 2.25-2.25V9.574c0-1.067-.796-1.974-1.803-2.166a48.756 48.756 0 00-1.132-.178 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.041 48.774 48.774 0 00-5.324 0 2.192 2.192 0 00-1.736 1.041l-.822 1.316z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                    </svg>
                    Foto Selfie Absen
                </span>
                <span id="status-foto"
                    class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400">
                    Belum ambil foto
                </span>
            </div>

            <div class="p-5">
                <div class="relative mx-auto max-w-sm overflow-hidden rounded-xl bg-slate-900" style="aspect-ratio: 3/4;">
                    <video id="video-cam" autoplay playsinline muted class="h-full w-full object-cover"></video>
                    <img id="preview-foto" class="hidden h-full w-full object-cover" alt="Preview foto selfie">
                </div>
                <canvas id="canvas-cam" class="hidden"></canvas>

                <p id="camera-error" class="mt-2 hidden text-center text-sm text-red-600 dark:text-red-400"></p>

                <div class="mt-3 flex justify-center gap-3">
                    <button type="button" id="btn-ambil-foto"
                        class="flex items-center justify-center gap-2 rounded-xl bg-slate-700 px-5 py-2.5 font-semibold text-white transition hover:bg-slate-800 disabled:cursor-not-allowed disabled:opacity-50">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.113-1.132.178C3.046 7.6 2.25 8.507 2.25 9.574v9.176c0 1.24 1.01 2.25 2.25 2.25h15c1.24 0 2.25-1.01 2.25-2.25V9.574c0-1.067-.796-1.974-1.803-2.166a48.756 48.756 0 00-1.132-.178 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.041 48.774 48.774 0 00-5.324 0 2.192 2.192 0 00-1.736 1.041l-.822 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z" />
                        </svg>
                        Ambil Foto
                    </button>
                    <button type="button" id="btn-ulang-foto"
                        class="hidden items-center justify-center gap-2 rounded-xl border border-slate-300 px-5 py-2.5 font-semibold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-800">
                        Ambil Ulang
                    </button>
                </div>
            </div>
        </div>
        @endif

        {{-- Tombol Absen --}}
        <div>
            @if (!$presensi || !$presensi->jam_masuk)
            <form action="{{ route('karyawan.presensi.masuk') }}" method="POST" id="form-masuk">
                @csrf
                <input type="hidden" name="latitude" id="lat-masuk">
                <input type="hidden" name="longitude" id="lng-masuk">
                <input type="hidden" name="foto" id="foto-masuk">

                <button type="submit" id="btn-masuk"
                    class="flex w-full items-center justify-center rounded-xl bg-blue-600 py-3 text-lg font-semibold text-white transition hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 disabled:cursor-not-allowed disabled:opacity-50"
                    disabled>

                    <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9l3 3m0 0l-3 3m3-3H3m6.75-9H18a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0118 21H9.75" />
                    </svg>

                    Absen Masuk
                </button>
                <p id="hint-belum-lengkap" class="mt-2 text-center text-xs text-slate-400 dark:text-slate-500">
                    Pastikan lokasi dalam radius kantor &amp; foto selfie sudah diambil.
                </p>
            </form>
            @else
            <div
                class="rounded-xl border border-green-200 bg-green-50 p-4 text-center text-green-700 dark:border-green-800 dark:bg-green-900/30 dark:text-green-400">

                <svg class="mr-2 inline-block h-5 w-5 align-text-bottom" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                Anda sudah melakukan presensi hari ini. Terima kasih!
            </div>
            @endif

        </div>
    </div>
</div>

<div id="lokasi-config" data-lat="{{ $lokasi ? $lokasi->latitude : -6.2 }}"
    data-lng="{{ $lokasi ? $lokasi->longitude : 106.816666 }}"
    data-radius="{{ $lokasi ? $lokasi->radius_meter : 100 }}" style="display:none;">
</div>

@endsection

@push('scripts')
{{-- Leaflet.js untuk peta --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Jam real-time
    setInterval(() => {
        const now = new Date();
        document.getElementById('jam-sekarang').textContent =
            now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
    }, 1000);

    // Koordinat kantor dari server
    const lokasiConfig = document.getElementById('lokasi-config').dataset;
    const kantorLat = parseFloat(lokasiConfig.lat);
    const kantorLng = parseFloat(lokasiConfig.lng);
    const radius = parseFloat(lokasiConfig.radius);

    // Init peta
    const map = L.map('map').setView([kantorLat, kantorLng], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Marker kantor
    L.circle([kantorLat, kantorLng], {
        color: '#2e5fa3',
        fillColor: '#2e5fa3',
        fillOpacity: 0.15,
        radius: radius
    }).addTo(map);
    L.marker([kantorLat, kantorLng])
        .addTo(map)
        .bindPopup('<b>Lokasi Kantor</b>').openPopup();

    // Hitung jarak Haversine
    function hitungJarak(lat1, lng1, lat2, lng2) {
        const R = 6371000;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLng / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    let userMarker = null;
    let dalamRadius = false;
    let fotoDiambil = false;
    let lastLat = null;
    let lastLng = null;

    // Update state tombol absen: aktif hanya jika dalam radius DAN foto sudah diambil
    function updateTombolAbsen() {
        const btnM = document.getElementById('btn-masuk');
        if (btnM) {
            btnM.disabled = !(dalamRadius && fotoDiambil);
        }
        const hint = document.getElementById('hint-belum-lengkap');
        if (hint) {
            hint.classList.toggle('hidden', dalamRadius && fotoDiambil);
        }
    }

    // Deteksi GPS
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const jarak = Math.round(hitungJarak(lat, lng, kantorLat, kantorLng));

            lastLat = lat;
            lastLng = lng;

            document.getElementById('lat-val').textContent = lat.toFixed(6);
            document.getElementById('lng-val').textContent = lng.toFixed(6);
            document.getElementById('jarak-val').textContent = jarak;

            // Isi hidden input
            const latMasuk = document.getElementById('lat-masuk');
            if (latMasuk) latMasuk.value = lat;

            const lngMasuk = document.getElementById('lng-masuk');
            if (lngMasuk) lngMasuk.value = lng;

            // Update marker user
            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: '',
                    html: '<div style="background:#dc3545;width:14px;height:14px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 4px rgba(0,0,0,.4)"></div>'
                })
            }).addTo(map).bindPopup('Lokasi Anda');

            // Update status radius
            dalamRadius = jarak <= radius;
            const statusEl = document.getElementById('status-gps');
            statusEl.textContent = dalamRadius ? '✓ Dalam radius kantor' : `✗ Di luar radius (${jarak}m)`;
            statusEl.className = dalamRadius ?
                'rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700' :
                'rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700';

            updateTombolAbsen();

        }, err => {
            const statusEl = document.getElementById('status-gps');
            statusEl.textContent = 'GPS tidak tersedia';
            statusEl.className = 'rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700';
        }, {
            enableHighAccuracy: true,
            maximumAge: 10000,
            timeout: 10000
        });
    }

    // ============================================================
    // Kamera Selfie + Watermark (jam & koordinat)
    // ============================================================
    const videoEl = document.getElementById('video-cam');
    const canvasEl = document.getElementById('canvas-cam');
    const previewEl = document.getElementById('preview-foto');
    const btnAmbil = document.getElementById('btn-ambil-foto');
    const btnUlang = document.getElementById('btn-ulang-foto');
    const statusFoto = document.getElementById('status-foto');
    const cameraError = document.getElementById('camera-error');
    const fotoInput = document.getElementById('foto-masuk');

    let cameraStream = null;

    async function mulaiKamera() {
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            tampilkanErrorKamera('Browser tidak mendukung akses kamera.');
            return;
        }
        try {
            cameraStream = await navigator.mediaDevices.getUserMedia({
                video: {
                    facingMode: 'user'
                },
                audio: false
            });
            if (videoEl) {
                videoEl.srcObject = cameraStream;
            }
        } catch (err) {
            tampilkanErrorKamera('Tidak bisa mengakses kamera. Izinkan akses kamera pada browser Anda.');
        }
    }

    function tampilkanErrorKamera(pesan) {
        if (cameraError) {
            cameraError.textContent = pesan;
            cameraError.classList.remove('hidden');
        }
        if (btnAmbil) btnAmbil.disabled = true;
    }

    function formatWatermarkWaktu() {
        const now = new Date();
        return now.toLocaleDateString('id-ID', {
            weekday: 'long',
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        }) + ' ' + now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }

    function ambilFoto() {
        if (!videoEl || !videoEl.videoWidth) return;

        canvasEl.width = videoEl.videoWidth;
        canvasEl.height = videoEl.videoHeight;
        const ctx = canvasEl.getContext('2d');

        // Mirror horizontal supaya sesuai preview (selfie)
        ctx.translate(canvasEl.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(videoEl, 0, 0, canvasEl.width, canvasEl.height);
        ctx.setTransform(1, 0, 0, 1, 0, 0); // reset transform

        // Susun teks watermark
        const baris1 = formatWatermarkWaktu();
        const lat = lastLat !== null ? lastLat.toFixed(6) : '-';
        const lng = lastLng !== null ? lastLng.toFixed(6) : '-';
        const baris2 = `Lat: ${lat}, Lng: ${lng}`;

        const fontSize = Math.max(14, Math.round(canvasEl.width / 28));
        ctx.font = `600 ${fontSize}px sans-serif`;
        const paddingX = 14;
        const lineHeight = fontSize * 1.4;
        const boxHeight = lineHeight * 2 + 16;

        // Background semi transparan di bawah foto
        ctx.fillStyle = 'rgba(0,0,0,0.55)';
        ctx.fillRect(0, canvasEl.height - boxHeight, canvasEl.width, boxHeight);

        // Teks watermark
        ctx.fillStyle = '#ffffff';
        ctx.textBaseline = 'middle';
        ctx.fillText(baris1, paddingX, canvasEl.height - boxHeight + lineHeight * 0.5 + 8);
        ctx.fillText(baris2, paddingX, canvasEl.height - boxHeight + lineHeight * 1.5 + 8);

        const dataUrl = canvasEl.toDataURL('image/jpeg', 0.85);

        if (fotoInput) fotoInput.value = dataUrl;
        if (previewEl) {
            previewEl.src = dataUrl;
            previewEl.classList.remove('hidden');
        }
        if (videoEl) videoEl.classList.add('hidden');

        fotoDiambil = true;

        if (statusFoto) {
            statusFoto.textContent = '✓ Foto siap';
            statusFoto.className = 'rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700';
        }

        if (btnAmbil) btnAmbil.classList.add('hidden');
        if (btnUlang) btnUlang.classList.remove('hidden');

        updateTombolAbsen();
    }

    function ambilUlangFoto() {
        fotoDiambil = false;
        if (fotoInput) fotoInput.value = '';
        if (previewEl) {
            previewEl.classList.add('hidden');
            previewEl.src = '';
        }
        if (videoEl) videoEl.classList.remove('hidden');
        if (statusFoto) {
            statusFoto.textContent = 'Belum ambil foto';
            statusFoto.className = 'rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500 dark:bg-slate-800 dark:text-slate-400';
        }
        if (btnAmbil) btnAmbil.classList.remove('hidden');
        if (btnUlang) btnUlang.classList.add('hidden');
        updateTombolAbsen();
    }

    if (btnAmbil) btnAmbil.addEventListener('click', ambilFoto);
    if (btnUlang) btnUlang.addEventListener('click', ambilUlangFoto);

    if (videoEl) {
        mulaiKamera();
    }

    // Validasi terakhir sebelum submit (jaga-jaga jika tombol ter-enable manual via devtools)
    const formMasuk = document.getElementById('form-masuk');
    if (formMasuk) {
        formMasuk.addEventListener('submit', function(e) {
            if (!dalamRadius || !fotoDiambil) {
                e.preventDefault();
                alert('Pastikan Anda berada dalam radius kantor dan sudah mengambil foto selfie.');
            }
        });
    }
</script>
@endpush