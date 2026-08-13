<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\Izin;
use App\Models\Honorarium;
use App\Models\KalenderKerja;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Dashboard Admin
    public function admin()
    {
        $today        = Carbon::today();
        $bulan        = $today->month;
        $tahun        = $today->year;

        $totalKaryawan   = Karyawan::where('status', 'aktif')->count();
        $hadirHariIni    = Presensi::whereDate('tanggal', $today)->where('status', 'hadir')->count();
        $izinPending     = Izin::where('status', 'pending')->count();
        $honorariumDraft = Honorarium::where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'draft')->count();

        // ==== Data untuk Grafik Tren Kehadiran (filter periode) ====
        $periode = request('periode', '7hari');

        switch ($periode) {
            case 'bulan_ini':
                $startTren = $today->copy()->startOfMonth();
                $endTren   = $today->copy(); // sampai hari ini, tanggal depan belum ada data
                break;

            case 'bulan_lalu':
                $startTren = $today->copy()->subMonthNoOverflow()->startOfMonth();
                $endTren   = $today->copy()->subMonthNoOverflow()->endOfMonth();
                break;

            default:
                $periode   = '7hari';
                $startTren = $today->copy()->subDays(6);
                $endTren   = $today->copy();
                break;
        }

        $tanggalTren     = [];
        $jumlahHadirTren = [];

        for ($tanggal = $startTren->copy(); $tanggal->lte($endTren); $tanggal->addDay()) {
            $tanggalTren[]     = $tanggal->translatedFormat('d M');
            $jumlahHadirTren[] = Presensi::whereDate('tanggal', $tanggal)
                ->where('status', 'hadir')
                ->count();
        }

        // ==== Data untuk Grafik Status Hari Ini ====
        $statusPresensiHariIni = Presensi::whereDate('tanggal', $today)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $hadirStatus = $statusPresensiHariIni['hadir'] ?? 0;
        $izinStatus  = $statusPresensiHariIni['izin'] ?? 0;
        $sakitStatus = $statusPresensiHariIni['sakit'] ?? 0;
        $belumAbsen  = max($totalKaryawan - ($hadirStatus + $izinStatus + $sakitStatus), 0);

        $statusLabels = ['Hadir', 'Izin', 'Sakit', 'Belum Absen'];
        $statusData   = [$hadirStatus, $izinStatus, $sakitStatus, $belumAbsen];

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'izinPending',
            'honorariumDraft',
            'tanggalTren',
            'jumlahHadirTren',
            'statusLabels',
            'statusData',
            'periode'
        ));
    }

    // Dashboard Pimpinan
    public function pimpinan()
    {
        $today     = Carbon::today();
        $bulan     = $today->month;
        $tahun     = $today->year;

        $totalKaryawan = Karyawan::where('status', 'aktif')->count();
        $hadirHariIni = Presensi::whereDate('tanggal', $today)
            ->where('status', 'hadir')
            ->count();

        $totalIzinPending = Izin::where('status', 'pending')->count();

        $honorariumDraft = Honorarium::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'draft')
            ->count();

        $izinPending = Izin::where('status', 'pending')
            ->with('karyawan')
            ->latest()
            ->take(5)
            ->get();

        // ==== Data untuk Grafik Tren Kehadiran (filter periode) ====
        $periode = request('periode', '7hari');

        switch ($periode) {
            case 'bulan_ini':
                $startTren = $today->copy()->startOfMonth();
                $endTren   = $today->copy(); // sampai hari ini, tanggal depan belum ada data
                break;

            case 'bulan_lalu':
                $startTren = $today->copy()->subMonthNoOverflow()->startOfMonth();
                $endTren   = $today->copy()->subMonthNoOverflow()->endOfMonth();
                break;

            default:
                $periode   = '7hari';
                $startTren = $today->copy()->subDays(6);
                $endTren   = $today->copy();
                break;
        }

        $tanggalTren     = [];
        $jumlahHadirTren = [];

        for ($tanggal = $startTren->copy(); $tanggal->lte($endTren); $tanggal->addDay()) {
            $tanggalTren[]     = $tanggal->translatedFormat('d M');
            $jumlahHadirTren[] = Presensi::whereDate('tanggal', $tanggal)
                ->where('status', 'hadir')
                ->count();
        }

        // ==== Data untuk Grafik Status Hari Ini ====
        $statusPresensiHariIni = Presensi::whereDate('tanggal', $today)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $hadirStatus = $statusPresensiHariIni['hadir'] ?? 0;
        $izinStatus  = $statusPresensiHariIni['izin'] ?? 0;
        $sakitStatus = $statusPresensiHariIni['sakit'] ?? 0;
        $belumAbsen  = max($totalKaryawan - ($hadirStatus + $izinStatus + $sakitStatus), 0);

        $statusLabels = ['Hadir', 'Izin', 'Sakit', 'Belum Absen'];
        $statusData   = [$hadirStatus, $izinStatus, $sakitStatus, $belumAbsen];

        return view('pimpinan.dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'totalIzinPending',
            'honorariumDraft',
            'izinPending',
            'tanggalTren',
            'jumlahHadirTren',
            'statusLabels',
            'statusData',
            'periode'
        ));
    }

    // Dashboard Karyawan
    public function karyawan()
    {
        $karyawan = Auth::user()->karyawan;
        $today     = Carbon::today();
        $bulan     = $today->month;
        $tahun     = $today->year;

        $presensiHariIni = Presensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $today)
            ->first();

        $rekapBulanIni = Presensi::where('karyawan_id', $karyawan->id)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // Alpha bukan status yang dicatat manual di tabel presensi,
        // jadi dihitung dari hari kerja bulan ini dikurangi hadir/izin/sakit
        // (sama seperti formula total_alpha di proses generate honorarium)
        //
        // PENTING: hari kerja yang dihitung dibatasi mulai dari tanggal_masuk
        // karyawan (bukan awal bulan), supaya karyawan yang baru join di
        // tengah bulan tidak dianggap Alpha untuk hari-hari sebelum dia
        // resmi jadi karyawan. Pola ini disamakan dengan HonorariumController::generate().
        $batasAwal = $karyawan->tanggal_masuk
            ? Carbon::parse($karyawan->tanggal_masuk)->startOfDay()
            : null;

        $totalHariKerja = KalenderKerja::where('is_hari_kerja', true)
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->whereDate('tanggal', '<=', $today)
            ->when($batasAwal, function ($query) use ($batasAwal) {
                $query->whereDate('tanggal', '>=', $batasAwal);
            })
            ->count();

        $rekapBulanIni['alpha'] = max(
            $totalHariKerja
                - ($rekapBulanIni['hadir'] ?? 0)
                - ($rekapBulanIni['izin'] ?? 0)
                - ($rekapBulanIni['sakit'] ?? 0),
            0
        );

        $honorariumTerakhir = Honorarium::where('karyawan_id', $karyawan->id)
            ->latest()
            ->first();

        return view('karyawan.dashboard', compact(
            'karyawan',
            'presensiHariIni',
            'rekapBulanIni',
            'honorariumTerakhir'
        ));
    }
}
