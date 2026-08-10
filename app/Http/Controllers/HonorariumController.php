<?php

namespace App\Http\Controllers;

use App\Models\Honorarium;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\PengaturanGaji;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\KalenderKerja;
use App\Models\LogAktivitas;

class HonorariumController extends Controller
{
    // Daftar honorarium (Admin)
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $honorarium = Honorarium::with("karyawan")
            ->where("bulan", $bulan)
            ->where("tahun", $tahun)
            ->paginate(20);

        if (Auth::user()->role === 'pimpinan') {
            return view(
                'pimpinan.honorarium.index',
                compact('honorarium', 'bulan', 'tahun')
            );
        }

        return view(
            'admin.honorarium.index',
            compact('honorarium', 'bulan', 'tahun')
        );
    }

    // Generate honorarium semua karyawan aktif
    public function generate(Request $request)
    {
        $request->validate([
            "bulan" => "required|integer|min:1|max:12",
            "tahun" => "required|integer|min:2020",
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $karyawans = Karyawan::where("status", "aktif")
            ->with("jabatan.pengaturanGaji")
            ->get();

        foreach ($karyawans as $karyawan) {

            $setting = $karyawan->jabatan?->pengaturanGaji;

            if (!$setting) {
                continue;
            }

            // Rekap presensi bulan ini
            $rekap = Presensi::where("karyawan_id", $karyawan->id)
                ->whereMonth("tanggal", $bulan)
                ->whereYear("tanggal", $tahun)
                ->selectRaw("status, COUNT(*) as total")
                ->groupBy("status")
                ->pluck("total", "status");

            $totalHadir = $rekap["hadir"] ?? 0;
            $totalIzin  = $rekap["izin"] ?? 0;
            $totalSakit = $rekap["sakit"] ?? 0;

            // Jumlah hari kerja dari kalender kerja
            $jumlahHariKerja = KalenderKerja::whereMonth("tanggal", $bulan)
                ->whereYear("tanggal", $tahun)
                ->where("is_hari_kerja", true)
                ->count();

            // Alpha otomatis
            $totalAlpha = max(
                0,
                $jumlahHariKerja - (
                    $totalHadir +
                    $totalIzin +
                    $totalSakit
                )
            );

            // Hanya Alpha yang memotong gaji
            $potonganAlpha = $jumlahHariKerja > 0
                ? ($setting->gaji_pokok / $jumlahHariKerja) * $totalAlpha
                : 0;

            $totalPotongan = $potonganAlpha;

            // Bonus bulanan dari pengaturan gaji
            $bonus = $setting->bonus;

            // Gaji bersih
            $gajiBersih =
                $setting->gaji_pokok
                + $bonus
                - $totalPotongan;

            Honorarium::updateOrCreate(
                [
                    "karyawan_id" => $karyawan->id,
                    "bulan" => $bulan,
                    "tahun" => $tahun,
                ],
                [
                    "total_hadir" => $totalHadir,
                    "total_izin" => $totalIzin,
                    "total_sakit" => $totalSakit,
                    "total_alpha" => $totalAlpha,

                    "gaji_pokok" => $setting->gaji_pokok,
                    "bonus" => $bonus,

                    "total_potongan" => $totalPotongan,
                    "gaji_bersih" => $gajiBersih,

                    "status" => "draft",
                ]
            );
        }

        $route = Auth::user()->role === 'pimpinan'
            ? 'pimpinan.honorarium.index'
            : 'admin.honorarium.index';

        LogAktivitas::catat('generate_honorarium', "Generate honorarium periode {$bulan}/{$tahun}.");

        return redirect()
            ->route($route, [
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])
            ->with('success', 'Honorarium berhasil digenerate.');
    }

    // Finalisasi honorarium
    public function finalize(Request $request)
    {
        $request->validate([
            "bulan" => "required|integer",
            "tahun" => "required|integer",
        ]);

        Honorarium::where("bulan", $request->bulan)
            ->where("tahun", $request->tahun)
            ->update(["status" => "final"]);

        LogAktivitas::catat('finalize_honorarium', "Finalisasi honorarium periode {$request->bulan}/{$request->tahun}.");

        return back()->with(
            "success",
            "Honorarium bulan ini telah difinalisasi.",
        );
    }

    // Detail honorarium karyawan
    public function show(Honorarium $honorarium)
    {
        $honorarium->load('karyawan');

        if (Auth::user()->role === 'pimpinan') {
            return view('pimpinan.honorarium.show', compact('honorarium'));
        }

        return view('admin.honorarium.show', compact('honorarium'));
    }

    // Honorarium karyawan sendiri
    public function milik()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        $honorarium = Honorarium::where("karyawan_id", $karyawan->id)
            ->orderByDesc("tahun")
            ->orderByDesc("bulan")
            ->paginate(12);

        return view("karyawan.honorarium.index", compact("honorarium"));
    }
}
