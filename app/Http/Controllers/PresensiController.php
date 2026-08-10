<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PengaturanLokasi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\PengaturanJam;
use App\Models\KalenderKerja;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\LogAktivitas;

class PresensiController extends Controller
{
    // Halaman absen karyawan
    public function index()
    {
        $user = Auth::user();
        $karyawan  = $user->karyawan;
        $today     = Carbon::today();

        $presensi  = Presensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        $lokasi    = PengaturanLokasi::where('aktif', true)->first();
        $jamKerja = \App\Models\PengaturanJam::aktif();

        return view('karyawan.presensi.index', compact('presensi', 'lokasi', 'today', 'jamKerja'));
    }

    // Proses absen masuk
    public function absenMasuk(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto'      => 'required|string|starts_with:data:image/',
        ]);

        $user = Auth::user();
        $karyawan = $user->karyawan;
        $today = Carbon::today();

        // Cek kalender kerja
        $kalender = KalenderKerja::whereDate('tanggal', $today)->first();

        if ($kalender && !$kalender->is_hari_kerja) {
            return back()->with(
                'error',
                'Hari ini merupakan hari libur. Anda tidak dapat melakukan absen.'
            );
        }

        // Cek sudah absen masuk hari ini
        $existing = Presensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        // Validasi GPS
        $lokasi = PengaturanLokasi::where('aktif', true)->first();
        if ($lokasi) {
            $jarak = Presensi::hitungJarak(
                $request->latitude,
                $request->longitude,
                $lokasi->latitude,
                $lokasi->longitude
            );
            if ($jarak > $lokasi->radius_meter) {
                return back()->with('error', "Anda berada di luar radius kantor. Jarak: " . round($jarak) . " meter.");
            }
        }

        // Validasi jam masuk: hanya tolak kalau absen SEBELUM jam mulai.
        // Kalau lewat jam selesai (telat), absen tetap diterima tapi ditandai "Terlambat".
        $jamSetting = PengaturanJam::aktif();
        $keteranganWaktu = null;

        if ($jamSetting) {
            $now     = Carbon::now()->format('H:i:s');
            $mulai   = $jamSetting->jam_masuk_mulai;
            $selesai = $jamSetting->jam_masuk_selesai;

            if ($now < $mulai) {
                return back()->with(
                    'error',
                    "Absen masuk baru bisa dilakukan mulai jam {$mulai}."
                );
            }

            $keteranganWaktu = $now > $selesai ? 'Terlambat' : 'Tepat Waktu';
        }

        // Simpan foto selfie (sudah ada watermark jam & koordinat dari sisi client)
        $fotoPath = $this->simpanFotoBase64($request->foto, $karyawan->id);

        if (!$fotoPath) {
            return back()->with('error', 'Foto absen gagal diproses. Silakan coba lagi.');
        }

        Presensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal'     => $today,
            'jam_masuk'   => Carbon::now()->format('H:i:s'),
            'lat_masuk'   => $request->latitude,
            'lng_masuk'   => $request->longitude,
            'foto_masuk'  => $fotoPath,
            'status'      => 'hadir',
            'keterangan'  => $keteranganWaktu,
        ]);

        $pesanLog = 'Absen masuk oleh ' . $karyawan->nama
            . ($keteranganWaktu ? " ({$keteranganWaktu})." : '.');
        LogAktivitas::catat('absen_masuk', $pesanLog);

        $pesanSukses = $keteranganWaktu === 'Terlambat'
            ? 'Absen masuk berhasil dicatat. Anda tercatat terlambat.'
            : 'Absen masuk berhasil dicatat.';

        return back()->with('success', $pesanSukses);
    }

    // Decode foto base64 (data:image/...;base64,....) hasil capture kamera & simpan ke storage
    private function simpanFotoBase64(string $base64Image, int $karyawanId): ?string
    {
        try {
            if (!preg_match('/^data:image\/(png|jpe?g|webp);base64,(.+)$/', $base64Image, $matches)) {
                return null;
            }

            $extension = $matches[1] === 'jpeg' ? 'jpg' : $matches[1];
            $data      = base64_decode($matches[2]);

            if ($data === false || strlen($data) < 100) {
                return null;
            }

            // Batasi ukuran file maksimal 5MB untuk mencegah penyalahgunaan
            if (strlen($data) > 5 * 1024 * 1024) {
                return null;
            }

            $filename = 'presensi/masuk/' . $karyawanId . '_' . Carbon::now()->format('Ymd_His') . '_' . Str::random(6) . '.' . $extension;

            Storage::disk('public')->put($filename, $data);

            return $filename;
        } catch (\Throwable $e) {
            return null;
        }
    }

    // Rekap presensi (Admin & Pimpinan)
    public function rekap(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $presensi = Presensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->latest('tanggal')
            ->paginate(20);

        $karyawan = Karyawan::where('status', 'aktif')->get();

        if (Auth::user()->role === 'pimpinan') {
            return view(
                'pimpinan.presensi.rekap',
                compact('presensi', 'karyawan', 'bulan', 'tahun')
            );
        }

        return view(
            'admin.presensi.rekap',
            compact('presensi', 'karyawan', 'bulan', 'tahun')
        );
    }

    // Riwayat presensi karyawan sendiri
    public function riwayat(Request $request)
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;
        $bulan    = $request->bulan ?? Carbon::now()->month;
        $tahun    = $request->tahun ?? Carbon::now()->year;

        $presensi = Presensi::where('karyawan_id', $karyawan->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->paginate(20);

        return view('karyawan.presensi.riwayat', compact('presensi', 'bulan', 'tahun'));
    }
}
