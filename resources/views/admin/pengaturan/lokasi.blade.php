@extends('layouts.app')

@section('title', 'Pengaturan Lokasi GPS')
@section('page-title', 'Pengaturan Lokasi GPS')

@push('styles')
<style>
    #map-pengaturan {
        height: 350px;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-geo-alt text-danger me-2"></i>Lokasi Kantor & Radius Absen
            </div>
            <div class="card-body">
                @if($lokasi)
                <form action="{{ route('admin.pengaturan.lokasi.update', $lokasi) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lokasi</label>
                        <input type="text" name="nama_lokasi"
                            class="form-control @error('nama_lokasi') is-invalid @enderror"
                            value="{{ old('nama_lokasi', $lokasi->nama_lokasi) }}" required>
                        @error('nama_lokasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Latitude</label>
                            <input type="number" name="latitude" id="input-lat" step="any"
                                class="form-control @error('latitude') is-invalid @enderror"
                                value="{{ old('latitude', $lokasi->latitude) }}" required>
                            @error('latitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Longitude</label>
                            <input type="number" name="longitude" id="input-lng" step="any"
                                class="form-control @error('longitude') is-invalid @enderror"
                                value="{{ old('longitude', $lokasi->longitude) }}" required>
                            @error('longitude')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Radius Toleransi: <span id="radius-label" class="text-primary">{{ $lokasi->radius_meter }}</span> meter
                        </label>
                        <input type="range" name="radius_meter" id="input-radius"
                            class="form-range"
                            value="{{ old('radius_meter', $lokasi->radius_meter) }}"
                            min="10" max="1000" step="10">
                        <div class="d-flex justify-content-between text-muted small">
                            <span>10m</span><span>500m</span><span>1000m</span>
                        </div>
                    </div>

                    {{-- Tips ambil koordinat --}}
                    <div class="alert alert-info small">
                        <i class="bi bi-lightbulb me-1"></i>
                        <strong>Tips:</strong> Klik pada peta di bawah untuk mengambil koordinat lokasi kantor secara akurat,
                        atau gunakan tombol <strong>"Gunakan Lokasi Saya"</strong>.
                    </div>

                    <div class="d-flex gap-2 mb-3">
                        <button type="button" id="btn-my-location" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-crosshair me-1"></i>Gunakan Lokasi Saya
                        </button>
                        <span id="gps-status" class="text-muted small align-self-center"></span>
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-2"></i>Simpan Pengaturan
                        </button>
                    </div>
                </form>
                @else
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Data lokasi tidak ditemukan. Jalankan seeder terlebih dahulu.
                </div>
                @endif
            </div>
        </div>

        {{-- Peta Preview --}}
        <div class="card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-map text-success me-2"></i>Preview Peta
                <span class="text-muted small ms-2">(Klik pada peta untuk set koordinat)</span>
            </div>
            <div class="card-body p-2">
                <div id="map-pengaturan"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>

    const initLat = {{ $lokasi ? $lokasi->latitude : -6.200000 }};
    const initLng = {{ $lokasi ? $lokasi->longitude : 106.816666 }};
    const initRadius = {{ $lokasi ? $lokasi->radius_meter : 100 }};

    const inputLat = document.getElementById('input-lat');
    const inputLng = document.getElementById('input-lng');
    const inputRadius = document.getElementById('input-radius');
    const radiusLabel = document.getElementById('radius-label');

    // Init peta
    const map = L.map('map-pengaturan').setView([initLat, initLng], 17);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker = L.marker([initLat, initLng], {
        draggable: true
    }).addTo(map);
    let circle = L.circle([initLat, initLng], {
        color: '#2e5fa3',
        fillColor: '#2e5fa3',
        fillOpacity: 0.15,
        radius: initRadius
    }).addTo(map);

    // Update koordinat saat marker di-drag
    marker.on('dragend', e => {
        const pos = e.target.getLatLng();
        inputLat.value = pos.lat.toFixed(7);
        inputLng.value = pos.lng.toFixed(7);
        circle.setLatLng(pos);
    });

    // Klik peta untuk set lokasi
    map.on('click', e => {
        marker.setLatLng(e.latlng);
        circle.setLatLng(e.latlng);
        inputLat.value = e.latlng.lat.toFixed(7);
        inputLng.value = e.latlng.lng.toFixed(7);
    });

    // Slider radius
    inputRadius.addEventListener('input', () => {
        radiusLabel.textContent = inputRadius.value;
        circle.setRadius(parseInt(inputRadius.value));
    });

    // Gunakan lokasi saya
    document.getElementById('btn-my-location').addEventListener('click', () => {
        const status = document.getElementById('gps-status');
        status.textContent = 'Mendeteksi lokasi...';
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                inputLat.value = lat.toFixed(7);
                inputLng.value = lng.toFixed(7);
                marker.setLatLng([lat, lng]);
                circle.setLatLng([lat, lng]);
                map.setView([lat, lng], 17);
                status.textContent = '✓ Lokasi berhasil dideteksi';
                status.className = 'text-success small align-self-center';
            }, () => {
                status.textContent = '✗ GPS tidak tersedia';
                status.className = 'text-danger small align-self-center';
            });
        }
    });

    // Sync input manual ke peta
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
