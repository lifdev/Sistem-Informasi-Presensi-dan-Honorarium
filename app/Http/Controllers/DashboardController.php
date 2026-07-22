<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\Izin;
use App\Models\Honorarium;
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

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'hadirHariIni',
            'izinPending',
            'honorariumDraft'
        ));
    }

    // Dashboard Pimpinan
    public function pimpinan()
    {
        $today     = Carbon::today();
        $bulan     = $today->month;
        $tahun     = $today->year;

        $rekap = Presensi::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $izinPending = Izin::where('status', 'pending')->with('karyawan')->latest()->take(5)->get();

        return view('pimpinan.dashboard', compact('rekap', 'izinPending'));
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
