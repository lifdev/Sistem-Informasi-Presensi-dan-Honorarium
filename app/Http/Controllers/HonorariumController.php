<?php

namespace App\Http\Controllers;

use App\Models\Honorarium;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\PengaturanHonorarium;
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

        $queryHonorarium = Honorarium::with("karyawan")
            ->where("bulan", $bulan)
            ->where("tahun", $tahun);

        // Opsi "Tampilkan Semua": kalau ?show=all, per-page dibuat
        // sebesar total data yang cocok filter di atas. Tetap pakai
        // paginate() (bukan get()) supaya hasPages()/appends()/links()
        // yang dipanggil di view tidak error — cuma jadi 1 halaman.
        $tampilkanSemua = $request->show === 'all';

        $perPage = $tampilkanSemua
            ? max(1, $queryHonorarium->count())
            : 20;

        $honorarium = $queryHonorarium->paginate($perPage);

        // Flag: apakah periode yang sedang dilihat adalah bulan yang
        // masih berjalan (belum selesai penuh). Dipakai di view untuk
        // menampilkan badge "Sedang Berjalan" dan warning saat admin
        // mencoba Finalisasi sebelum bulan itu selesai.
        $sedangBerjalan = ((int) $bulan === Carbon::now()->month)
            && ((int) $tahun === Carbon::now()->year);

        if (Auth::user()->role === 'pimpinan') {
            return view(
                'pimpinan.honorarium.index',
                compact('honorarium', 'bulan', 'tahun', 'sedangBerjalan')
            );
        }

        return view(
            'admin.honorarium.index',
            compact('honorarium', 'bulan', 'tahun', 'sedangBerjalan')
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
            ->with("jabatan.pengaturanHonorarium")
            ->get();

        foreach ($karyawans as $karyawan) {

            $setting = $karyawan->jabatan?->pengaturanHonorarium;

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

            $totalAlphaTercatat = $rekap["alpha"] ?? 0;

            $jumlahHariKerja = KalenderKerja::whereMonth("tanggal", $bulan)
                ->whereYear("tanggal", $tahun)
                ->where("is_hari_kerja", true)
                ->count();

            $akhirPeriode = Carbon::create($tahun, $bulan, 1)->endOfMonth();
            $batasPenilaian = Carbon::now()->startOfDay()->lt($akhirPeriode)
                ? Carbon::now()->startOfDay()
                : $akhirPeriode;

            $batasAwal = $karyawan->tanggal_masuk
                ? Carbon::parse($karyawan->tanggal_masuk)->startOfDay()
                : null;

            $jumlahHariKerjaBerjalan = KalenderKerja::whereMonth("tanggal", $bulan)
                ->whereYear("tanggal", $tahun)
                ->where("is_hari_kerja", true)
                ->whereDate("tanggal", "<=", $batasPenilaian)
                ->when($batasAwal, function ($query) use ($batasAwal) {
                    $query->whereDate("tanggal", ">=", $batasAwal);
                })
                ->count();

            $totalTercatat = $totalHadir + $totalIzin + $totalSakit + $totalAlphaTercatat;

            $hariTanpaRecord = max(0, $jumlahHariKerjaBerjalan - $totalTercatat);

            $totalAlpha = $totalAlphaTercatat + $hariTanpaRecord;

            $existing = Honorarium::where("karyawan_id", $karyawan->id)
                ->where("bulan", $bulan)
                ->where("tahun", $tahun)
                ->first();

            $bonus = $existing->bonus ?? 0;

            if ($existing && $existing->status === "final") {
                continue;
            }

            if ($setting->isPerHadir()) {
                // Relawan guru / ustad part-time: dibayar per hari hadir.
                // Tidak ada potongan alpha — hari tidak hadir memang tidak dibayar.
                $honorariumPokok = $totalHadir * $setting->tarif_per_hadir;
                $totalPotongan = 0;
                $honorariumBersih = $honorariumPokok + $bonus;

                Honorarium::updateOrCreate(
                    [
                        "karyawan_id" => $karyawan->id,
                        "bulan" => $bulan,
                        "tahun" => $tahun,
                    ],
                    [
                        "tipe_honorarium" => "per_hadir",
                        "total_hadir" => $totalHadir,
                        "total_izin" => $totalIzin,
                        "total_sakit" => $totalSakit,
                        "total_alpha" => $totalAlpha,

                        "honorarium_pokok" => $honorariumPokok,
                        "tarif_per_hadir" => $setting->tarif_per_hadir,
                        "bonus" => $bonus,

                        "total_potongan" => $totalPotongan,
                        "honorarium_bersih" => $honorariumBersih,

                        "status" => "draft",
                    ]
                );

                continue;
            }

            // Karyawan tetap: honorarium flat bulanan, dipotong per hari alpha.
            $potonganAlpha = $jumlahHariKerja > 0
                ? ($setting->honorarium_pokok / $jumlahHariKerja) * $totalAlpha
                : 0;

            $totalPotongan = $potonganAlpha;

            $honorariumBersih =
                $setting->honorarium_pokok
                + $bonus
                - $totalPotongan;

            Honorarium::updateOrCreate(
                [
                    "karyawan_id" => $karyawan->id,
                    "bulan" => $bulan,
                    "tahun" => $tahun,
                ],
                [
                    "tipe_honorarium" => "bulanan",
                    "total_hadir" => $totalHadir,
                    "total_izin" => $totalIzin,
                    "total_sakit" => $totalSakit,
                    "total_alpha" => $totalAlpha,

                    "honorarium_pokok" => $setting->honorarium_pokok,
                    "tarif_per_hadir" => null,
                    "bonus" => $bonus,

                    "total_potongan" => $totalPotongan,
                    "honorarium_bersih" => $honorariumBersih,

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

    // Update bonus manual per karyawan (hanya boleh saat status draft)
    public function updateBonus(Request $request, Honorarium $honorarium)
    {
        if ($honorarium->status === "final") {
            return back()->with(
                "error",
                "Honorarium ini sudah difinalisasi, bonus tidak bisa diubah lagi.",
            );
        }

        $request->validate([
            "bonus" => "required|numeric|min:0",
        ]);

        $honorarium->update([
            "bonus" => $request->bonus,
            "honorarium_bersih" =>
            $honorarium->honorarium_pokok
                + $request->bonus
                - $honorarium->total_potongan,
        ]);

        LogAktivitas::catat(
            "update_bonus_honorarium",
            "Update bonus honorarium {$honorarium->karyawan?->nama} periode {$honorarium->bulan}/{$honorarium->tahun} menjadi Rp " .
                number_format($request->bonus, 0, ",", "."),
        );

        return back()->with("success", "Bonus berhasil disimpan.");
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
