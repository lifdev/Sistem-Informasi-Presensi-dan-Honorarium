@extends('layouts.app')

@section('title', 'Absen Hari Ini')
@section('page-title', 'Absen Hari Ini')

@push('styles')
<style>
    #map {
        height: 280px;
        border-radius: 10px;
        background: #e9ecef;
    }

    .absen-card {
        border-radius: 14px;
        overflow: hidden;
    }

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }
</style>
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-7">

        {{-- Info Tanggal --}}
        <div class="card mb-3 absen-card">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small">Hari ini</div>
                    <div class="fw-bold fs-5">{{ $today->translatedFormat('l, d F Y') }}</div>
                </div>
                <div class="text-end">
                    <div class="text-muted small">Jam</div>
                    <div class="fw-bold fs-5" id="jam-sekarang">--:--:--</div>
                </div>
            </div>
        </div>

        {{-- Status Absen --}}
        <div class="card mb-3 absen-card">
            <div class="card-header bg-white fw-semibold">
                <i class="bi bi-calendar-check text-primary me-2"></i>Status Absen
            </div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-6">
                        <div class="p-3 rounded-3 {{ $presensi && $presensi->jam_masuk ? 'bg-success bg-opacity-10 border border-success' : 'bg-light' }}">
                            <i class="bi bi-box-arrow-in-right fs-2 {{ $presensi && $presensi->jam_masuk ? 'text-success' : 'text-muted' }}"></i>
                            <div class="fw-semibold mt-1">Masuk</div>
                            <div class="fs-5 fw-bold {{ $presensi && $presensi->jam_masuk ? 'text-success' : 'text-muted' }}">
                                {{ $presensi && $presensi->jam_masuk ? $presensi->jam_masuk : '--:--' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 rounded-3 {{ $presensi && $presensi->jam_pulang ? 'bg-warning bg-opacity-10 border border-warning' : 'bg-light' }}">
                            <i class="bi bi-box-arrow-right fs-2 {{ $presensi && $presensi->jam_pulang ? 'text-warning' : 'text-muted' }}"></i>
                            <div class="fw-semibold mt-1">Pulang</div>
                            <div class="fs-5 fw-bold {{ $presensi && $presensi->jam_pulang ? 'text-warning' : 'text-muted' }}">
                                {{ $presensi && $presensi->jam_pulang ? $presensi->jam_pulang : '--:--' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Peta GPS --}}
        <div class="card mb-3 absen-card">
            <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
                <span><i class="bi bi-geo-alt text-danger me-2"></i>Lokasi GPS</span>
                <span id="status-gps" class="badge bg-secondary">Mendeteksi lokasi...</span>
            </div>
            <div class="card-body">
                <div id="map" class="mb-2"></div>
                <div class="d-flex justify-content-between text-muted small mt-2">
                    <span>Lat: <span id="lat-val">-</span></span>
                    <span>Lng: <span id="lng-val">-</span></span>
                    <span>Jarak: <span id="jarak-val">-</span> meter</span>
                </div>
            </div>
        </div>

        {{-- Tombol Absen --}}
        <div class="row g-3">
            @if(!$presensi || !$presensi->jam_masuk)
            <div class="col-12">
                <form action="{{ route('karyawan.presensi.masuk') }}" method="POST" id="form-masuk">
                    @csrf
                    <input type="hidden" name="latitude" id="lat-masuk">
                    <input type="hidden" name="longitude" id="lng-masuk">
                    <button type="submit" id="btn-masuk" class="btn btn-primary w-100 py-3 fs-5 fw-semibold" disabled>
                        <i class="bi bi-box-arrow-in-right me-2"></i>Absen Masuk
                    </button>
                </form>
            </div>
            @elseif($presensi && $presensi->jam_masuk && !$presensi->jam_pulang)
            <div class="col-12">
                <form action="{{ route('karyawan.presensi.pulang') }}" method="POST" id="form-pulang">
                    @csrf
                    <input type="hidden" name="latitude" id="lat-pulang">
                    <input type="hidden" name="longitude" id="lng-pulang">
                    <button type="submit" id="btn-pulang" class="btn btn-warning w-100 py-3 fs-5 fw-semibold" disabled>
                        <i class="bi bi-box-arrow-right me-2"></i>Absen Pulang
                    </button>
                </form>
            </div>
            @else
            <div class="col-12">
                <div class="alert alert-success text-center mb-0">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Anda sudah melakukan absen masuk dan pulang hari ini. Terima kasih!
                </div>
            </div>
            @endif
        </div>

    </div>
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
    const kantorLat = {
        {
            $lokasi ? $lokasi - > latitude : -6.200000
        }
    };
    const kantorLng = {
        {
            $lokasi ? $lokasi - > longitude : 106.816666
        }
    };
    const radius = {
        {
            $lokasi ? $lokasi - > radius_meter : 100
        }
    };

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

    // Deteksi GPS
    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(pos => {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const jarak = Math.round(hitungJarak(lat, lng, kantorLat, kantorLng));

            document.getElementById('lat-val').textContent = lat.toFixed(6);
            document.getElementById('lng-val').textContent = lng.toFixed(6);
            document.getElementById('jarak-val').textContent = jarak;

            // Isi hidden input
            ['lat-masuk', 'lat-pulang'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = lat;
            });
            ['lng-masuk', 'lng-pulang'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.value = lng;
            });

            // Update marker user
            if (userMarker) map.removeLayer(userMarker);
            userMarker = L.marker([lat, lng], {
                icon: L.divIcon({
                    className: '',
                    html: '<div style="background:#dc3545;width:14px;height:14px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 4px rgba(0,0,0,.4)"></div>'
                })
            }).addTo(map).bindPopup('Lokasi Anda');

            // Aktifkan tombol & update status
            const dlmRadius = jarak <= radius;
            const statusEl = document.getElementById('status-gps');
            statusEl.textContent = dlmRadius ? '✓ Dalam radius kantor' : `✗ Di luar radius (${jarak}m)`;
            statusEl.className = dlmRadius ? 'badge bg-success' : 'badge bg-danger';

            const btnM = document.getElementById('btn-masuk');
            const btnP = document.getElementById('btn-pulang');
            if (btnM) btnM.disabled = !dlmRadius;
            if (btnP) btnP.disabled = !dlmRadius;

        }, err => {
            document.getElementById('status-gps').textContent = 'GPS tidak tersedia';
            document.getElementById('status-gps').className = 'badge bg-danger';
        }, {
            enableHighAccuracy: true,
            maximumAge: 10000,
            timeout: 10000
        });
    }
</script>
@endpush