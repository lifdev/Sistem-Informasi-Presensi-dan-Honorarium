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

            // FIX: ambil Alpha langsung dari data presensi asli,
            // bukan hasil selisih dari KalenderKerja. Row status
            // "alpha" yang sudah tercatat di tabel presensi adalah
            // sumber kebenaran (source of truth) untuk absensi,
            // sehingga tidak boleh dibuang/diabaikan.
            $totalAlphaTercatat = $rekap["alpha"] ?? 0;

            // Jumlah hari kerja dari kalender kerja (dipakai untuk
            // validasi kelengkapan data, bukan untuk menebak Alpha).
            // Nilai ini tetap total hari kerja SELURUH bulan, karena
            // dipakai sebagai pembagi potongan per hari (konsisten
            // dengan Pengaturan Gaji: gaji_pokok / jumlah hari kerja
            // sebulan).
            $jumlahHariKerja = KalenderKerja::whereMonth("tanggal", $bulan)
                ->whereYear("tanggal", $tahun)
                ->where("is_hari_kerja", true)
                ->count();

            // Batas akhir periode yang SUDAH BOLEH dinilai sebagai
            // Alpha: kalau bulan yang digenerate adalah bulan berjalan,
            // batasnya hari ini (hari yang belum lewat tidak mungkin
            // sudah "bolos"). Kalau bulan yang digenerate sudah lewat,
            // batasnya akhir bulan itu.
            $akhirPeriode = Carbon::create($tahun, $bulan, 1)->endOfMonth();
            $batasPenilaian = Carbon::now()->startOfDay()->lt($akhirPeriode)
                ? Carbon::now()->startOfDay()
                : $akhirPeriode;

            // Batas awal periode yang boleh dinilai sebagai Alpha:
            // tanggal masuk karyawan. Hari kerja SEBELUM karyawan
            // resmi masuk tidak boleh dihitung bolos, karena dia
            // belum menjadi karyawan pada hari itu.
            $batasAwal = $karyawan->tanggal_masuk
                ? Carbon::parse($karyawan->tanggal_masuk)->startOfDay()
                : null;

            // Hari kerja yang sudah lewat (yang seharusnya sudah ada
            // presensinya sampai hari ini/akhir bulan), dihitung mulai
            // dari tanggal masuk karyawan (kalau tanggal masuknya jatuh
            // di bulan ini) atau dari awal bulan (kalau dia sudah masuk
            // sebelum bulan ini).
            $jumlahHariKerjaBerjalan = KalenderKerja::whereMonth("tanggal", $bulan)
                ->whereYear("tanggal", $tahun)
                ->where("is_hari_kerja", true)
                ->whereDate("tanggal", "<=", $batasPenilaian)
                ->when($batasAwal, function ($query) use ($batasAwal) {
                    $query->whereDate("tanggal", ">=", $batasAwal);
                })
                ->count();

            $totalTercatat = $totalHadir + $totalIzin + $totalSakit + $totalAlphaTercatat;

            // Selisih hari kerja yang SUDAH LEWAT tapi sama sekali
            // belum ada record presensinya (misal admin lupa input).
            // Hari kerja yang belum terjadi TIDAK dihitung sebagai Alpha.
            $hariTanpaRecord = max(0, $jumlahHariKerjaBerjalan - $totalTercatat);

            $totalAlpha = $totalAlphaTercatat + $hariTanpaRecord;

            // Potongan per hari tetap dihitung dari total hari kerja
            // SEBULAN PENUH (bukan hari yang sudah lewat), supaya nilai
            // potongan per hari konsisten dengan yang ditampilkan di
            // Pengaturan Gaji.
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
