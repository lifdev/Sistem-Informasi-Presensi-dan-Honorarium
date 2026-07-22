<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\PengaturanLokasi;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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

        return view('karyawan.presensi.index', compact('presensi', 'lokasi', 'today'));
    }

    // Proses absen masuk
    public function absenMasuk(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $karyawan = $user->karyawan;
        $today    = Carbon::today();

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

        Presensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal'     => $today,
            'jam_masuk'   => Carbon::now()->format('H:i:s'),
            'lat_masuk'   => $request->latitude,
            'lng_masuk'   => $request->longitude,
            'status'      => 'hadir',
        ]);

        return back()->with('success', 'Absen masuk berhasil dicatat.');
    }

    // Proses absen pulang
    public function absenPulang(Request $request)
    {
        $request->validate([
            'latitude'  => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = Auth::user();
        $karyawan = $user->karyawan;
        $today    = Carbon::today();

        $presensi = Presensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        if (!$presensi) {
            return back()->with('error', 'Anda belum melakukan absen masuk.');
        }

        if ($presensi->jam_pulang) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        $presensi->update([
            'jam_pulang'  => Carbon::now()->format('H:i:s'),
            'lat_pulang'  => $request->latitude,
            'lng_pulang'  => $request->longitude,
        ]);

        return back()->with('success', 'Absen pulang berhasil dicatat.');
    }

    // Rekap presensi (Admin)
    public function rekap(Request $request)
    {
        $bulan    = $request->bulan ?? Carbon::now()->month;
        $tahun    = $request->tahun ?? Carbon::now()->year;

        $presensi = Presensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->latest('tanggal')
            ->paginate(20);

        $karyawan = Karyawan::where('status', 'aktif')->get();

        return view('admin.presensi.rekap', compact('presensi', 'karyawan', 'bulan', 'tahun'));
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
