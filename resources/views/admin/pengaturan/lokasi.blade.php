@extends('layouts.app')

@section('title', 'Pengaturan Lokasi GPS')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <style>
        #map-pengaturan {
            height: 420px;
            border-radius: 18px;
        }
    </style>
@endpush

@section('content')

    <div class="mx-auto max-w-7xl">

        <div class="mb-6">

            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
                Pengaturan Lokasi GPS
            </h1>

            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                Atur titik lokasi kantor dan radius presensi karyawan.
            </p>

        </div>

        @if ($lokasi)
            <div class="grid gap-6 lg:grid-cols-5">

                <div class="lg:col-span-2">

                    <form action="{{ route('admin.pengaturan.lokasi.update', $lokasi) }}" method="POST"
                        class="rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        @csrf
                        @method('PUT')

                        <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                            <div class="flex items-center gap-3">

                                <div class="rounded-xl bg-red-100 p-3 text-red-600 dark:bg-red-900/30 dark:text-red-400">

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657A8 8 0 1117.657 16.657z" />

                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0" />

                                    </svg>

                                </div>

                                <div>

                                    <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                                        Lokasi Kantor
                                    </h2>

                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Data lokasi utama presensi.
                                    </p>

                                </div>

                            </div>

                        </div>

                        <div class="space-y-6 p-6">

                            <div>

                                <label class="mb-2 block text-sm font-medium">
                                    Nama Lokasi
                                </label>

                                <input type="text" name="nama_lokasi"
                                    value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                            </div>

                            <div class="grid gap-5 sm:grid-cols-2">

                                <div>

                                    <label class="mb-2 block text-sm font-medium">
                                        Latitude
                                    </label>

                                    <input type="number" step="any" id="input-lat" name="latitude"
                                        value="{{ old('latitude', $lokasi->latitude) }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                                </div>

                                <div>

                                    <label class="mb-2 block text-sm font-medium">
                                        Longitude
                                    </label>

                                    <input type="number" step="any" id="input-lng" name="longitude"
                                        value="{{ old('longitude', $lokasi->longitude) }}"
                                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:border-slate-700 dark:bg-slate-800">

                                </div>

                            </div>

                            <div>

                                <div class="mb-3 flex items-center justify-between">

                                    <label class="text-sm font-medium">
                                        Radius Presensi
                                    </label>

                                    <span
                                        class="rounded-full bg-blue-100 px-3 py-1 text-sm font-semibold text-blue-600 dark:bg-blue-900/30 dark:text-blue-400">
                                        <span id="radius-label">{{ $lokasi->radius_meter }}</span> Meter
                                    </span>

                                </div>

                                <input type="range" id="input-radius" name="radius_meter" min="10" max="1000"
                                    step="10" value="{{ old('radius_meter', $lokasi->radius_meter) }}" class="w-full">

                                <div class="mt-2 flex justify-between text-xs text-slate-400">
                                    <span>10</span>
                                    <span>500</span>
                                    <span>1000</span>
                                </div>

                            </div>

                            <div
                                class="rounded-xl border border-blue-200 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950/30">

                                <p class="text-sm text-blue-700 dark:text-blue-300">

                                    Klik peta untuk memilih lokasi kantor atau gunakan GPS perangkat.

                                </p>

                            </div>

                            <div class="flex flex-wrap gap-3">

                                <button type="button" id="btn-my-location"
                                    class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-medium transition hover:bg-slate-100 dark:border-slate-700 dark:hover:bg-slate-800">

                                    Gunakan Lokasi Saya

                                </button>

                                <button type="submit"
                                    class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">

                                    Simpan Pengaturan

                                </button>

                            </div>

                            <p id="gps-status" class="text-sm text-slate-500"></p>

                        </div>

                    </form>

                </div>

                <div class="lg:col-span-3">

                    <div
                        class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

                        <div class="border-b border-slate-200 px-6 py-5 dark:border-slate-800">

                            <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                                Preview Peta
                            </h2>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                Klik area peta untuk memindahkan titik lokasi kantor.
                            </p>

                        </div>

                        <div class="p-4">

                            <div id="map-pengaturan"></div>

                        </div>

                    </div>

                </div>

            </div>
        @else
            <div
                class="rounded-2xl border border-dashed border-slate-300 bg-white py-20 text-center dark:border-slate-700 dark:bg-slate-900">

                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-16 w-16 text-slate-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0L6.343 16.657A8 8 0 1117.657 16.657z" />

                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0" />

                </svg>

                <h3 class="mt-5 text-lg font-semibold text-slate-700 dark:text-slate-200">
                    Lokasi Belum Tersedia
                </h3>

                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                    Jalankan seeder terlebih dahulu untuk membuat data lokasi.
                </p>

            </div>
        @endif

    </div>

    <div id="lokasi-config-pengaturan" data-lat="{{ $lokasi ? $lokasi->latitude : -6.2 }}"
        data-lng="{{ $lokasi ? $lokasi->longitude : 106.816666 }}" data-radius="{{ $lokasi ? $lokasi->radius_meter : 100 }}"
        style="display:none;">
    </div>

@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const lokasiConfigPengaturan = document.getElementById('lokasi-config-pengaturan').dataset;
        const initLat = parseFloat(lokasiConfigPengaturan.lat);
        const initLng = parseFloat(lokasiConfigPengaturan.lng);
        const initRadius = parseFloat(lokasiConfigPengaturan.radius);

        const inputLat = document.getElementById('input-lat');
        const inputLng = document.getElementById('input-lng');
        const inputRadius = document.getElementById('input-radius');
        const radiusLabel = document.getElementById('radius-label');

        const map = L.map('map-pengaturan').setView([initLat, initLng], 17);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let marker = L.marker([initLat, initLng], {
            draggable: true
        }).addTo(map);

        let circle = L.circle([initLat, initLng], {
            radius: initRadius,
            color: '#2563eb',
            fillColor: '#2563eb',
            fillOpacity: .15
        }).addTo(map);

        marker.on('dragend', e => {
            const pos = e.target.getLatLng();
            inputLat.value = pos.lat.toFixed(7);
            inputLng.value = pos.lng.toFixed(7);
            circle.setLatLng(pos);
        });

        map.on('click', e => {
            marker.setLatLng(e.latlng);
            circle.setLatLng(e.latlng);
            inputLat.value = e.latlng.lat.toFixed(7);
            inputLng.value = e.latlng.lng.toFixed(7);
        });

        inputRadius.addEventListener('input', () => {
            radiusLabel.textContent = inputRadius.value;
            circle.setRadius(inputRadius.value);
        });

        document.getElementById('btn-my-location').onclick = function() {

            const status = document.getElementById('gps-status');

            status.textContent = 'Mendeteksi lokasi...';

            navigator.geolocation.getCurrentPosition(pos => {

                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;

                inputLat.value = lat.toFixed(7);
                inputLng.value = lng.toFixed(7);

                marker.setLatLng([lat, lng]);
                circle.setLatLng([lat, lng]);

                map.setView([lat, lng], 17);

                status.textContent = 'Lokasi berhasil ditemukan.';

            }, () => {

                status.textContent = 'Gagal mendapatkan lokasi.';

            });

        };

        [inputLat, inputLng].forEach(el => {

            el.addEventListener('change', () => {

                const lat = parseFloat(inputLat.value);
                const lng = parseFloat(inputLng.value);

                if (!isNaN(lat) && !isNaN(lng)) {

                    marker.setLatLng([lat, lng]);
                    circle.setLatLng([lat, lng]);
                    map.setView([lat, lng], 17);

                }

            });

        });
    </script>
@endpush
