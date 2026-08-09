<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\IzinController;
use App\Http\Controllers\HonorariumController;
use App\Http\Controllers\PengaturanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\KalenderKerjaController;

// ============================================================
// AUTH ROUTES (Guest only)
// ============================================================

Route::middleware("guest")->group(function () {
    Route::get("/", [LoginController::class, "showLoginForm"])->name("login");
    Route::get("/login", [LoginController::class, "showLoginForm"]);
    Route::post("/login", [LoginController::class, "login"])->name(
        "login.post",
    );
});

Route::post("/logout", [LoginController::class, "logout"])
    ->middleware("auth")
    ->name("logout");

// ============================================================
// ADMIN ROUTES
// ============================================================

Route::middleware(["auth", "role:admin"])
    ->prefix("admin")
    ->name("admin.")
    ->group(function () {
        // Dashboard
        Route::get("/dashboard", [DashboardController::class, "admin"])->name(
            "dashboard",
        );

        // Karyawan
        Route::resource("karyawan", KaryawanController::class)->except([
            "show",
        ]);

        // Presensi
        Route::prefix("presensi")
            ->name("presensi.")
            ->group(function () {
                Route::get("/rekap", [
                    PresensiController::class,
                    "rekap",
                ])->name("rekap");
            });

        // Bidang
        Route::resource('bidang', BidangController::class);

        // Jabatan
        Route::resource('jabatan', JabatanController::class);

        // Izin
        Route::prefix("izin")
            ->name("izin.")
            ->group(function () {
                Route::get("/approval", [
                    IzinController::class,
                    "approval",
                ])->name("approval");
                Route::patch("/{izin}/approve", [
                    IzinController::class,
                    "approve",
                ])->name("approve");
                Route::patch("/{izin}/reject", [
                    IzinController::class,
                    "reject",
                ])->name("reject");
            });

        // Honorarium
        Route::prefix("honorarium")
            ->name("honorarium.")
            ->group(function () {
                Route::get("/", [HonorariumController::class, "index"])->name(
                    "index",
                );
                Route::post("/generate", [
                    HonorariumController::class,
                    "generate",
                ])->name("generate");
                Route::post("/finalize", [
                    HonorariumController::class,
                    "finalize",
                ])->name("finalize");
                Route::get("/{honorarium}", [
                    HonorariumController::class,
                    "show",
                ])->name("show");
            });

        // Pengaturan
        Route::prefix("pengaturan")
            ->name("pengaturan.")
            ->group(function () {
                Route::get("/gaji", [
                    PengaturanController::class,
                    "gaji",
                ])->name("gaji");
                Route::put("/gaji/{pengaturanGaji}", [
                    PengaturanController::class,
                    "updateGaji",
                ])->name("gaji.update");
                Route::get("/lokasi", [
                    PengaturanController::class,
                    "lokasi",
                ])->name("lokasi");
                Route::put("/lokasi/{pengaturanLokasi}", [
                    PengaturanController::class,
                    "updateLokasi",
                ])->name("lokasi.update");

                Route::get('/jam', [PengaturanController::class, 'jam'])->name('jam');
                Route::put('/jam', [PengaturanController::class, 'updateJam'])->name('jam.update');
            });

        // Kalender Kerja
        Route::prefix('kalender-kerja')
            ->name('kalender-kerja.')
            ->group(function () {

                Route::get('/', [KalenderKerjaController::class, 'index'])
                    ->name('index');

                Route::post('/generate', [KalenderKerjaController::class, 'generate'])
                    ->name('generate');

                Route::patch('/{kalenderKerja}', [KalenderKerjaController::class, 'update'])
                    ->name('update');
            });

        // Laporan & Ekspor
        Route::prefix("laporan")
            ->name("laporan.")
            ->group(function () {
                Route::get("/", [LaporanController::class, "index"])->name(
                    "index",
                );
                Route::get("/presensi/export-excel", [
                    LaporanController::class,
                    "exportPresensiExcel",
                ])->name("presensi.excel");
                Route::get("/presensi/export-pdf", [
                    LaporanController::class,
                    "exportPresensiPdf",
                ])->name("presensi.pdf");
                Route::get("/honorarium/export-excel", [
                    LaporanController::class,
                    "exportHonorariumExcel",
                ])->name("honorarium.excel");
                Route::get("/honorarium/export-pdf", [
                    LaporanController::class,
                    "exportHonorariumPdf",
                ])->name("honorarium.pdf");
                Route::get("/slip/{honorarium}", [
                    LaporanController::class,
                    "slipGaji",
                ])->name("slip");
            });
    });

// ============================================================
// PIMPINAN ROUTES
// ============================================================

Route::middleware(["auth", "role:pimpinan"])
    ->prefix("pimpinan")
    ->name("pimpinan.")
    ->group(function () {
        // Dashboard
        Route::get("/dashboard", [
            DashboardController::class,
            "pimpinan",
        ])->name("dashboard");

        // Approval Izin
        Route::prefix("izin")
            ->name("izin.")
            ->group(function () {
                Route::get("/approval", [
                    IzinController::class,
                    "approval",
                ])->name("approval");
                Route::patch("/{izin}/approve", [
                    IzinController::class,
                    "approve",
                ])->name("approve");
                Route::patch("/{izin}/reject", [
                    IzinController::class,
                    "reject",
                ])->name("reject");
            });

        // Lihat rekap presensi
        Route::get("/presensi/rekap", [
            PresensiController::class,
            "rekap",
        ])->name("presensi.rekap");

        // Lihat honorarium
        Route::get("/honorarium", [HonorariumController::class, "index"])
            ->name("honorarium.index");

        // Generate honorarium
        Route::post("/honorarium/generate", [
            HonorariumController::class,
            "generate",
        ])->name("honorarium.generate");

        // Finalisasi honorarium
        Route::post("/honorarium/finalize", [
            HonorariumController::class,
            "finalize",
        ])->name("honorarium.finalize");

        // Detail honorarium
        Route::get("/honorarium/{honorarium}", [
            HonorariumController::class,
            "show",
        ])->name("honorarium.show");

        // Laporan & Ekspor
        Route::prefix("laporan")
            ->name("laporan.")
            ->group(function () {

                // Presensi
                Route::get("/presensi/export-excel", [
                    LaporanController::class,
                    "exportPresensiExcel",
                ])->name("presensi.excel");

                Route::get("/presensi/export-pdf", [
                    LaporanController::class,
                    "exportPresensiPdf",
                ])->name("presensi.pdf");

                // Honorarium
                Route::get("/honorarium/export-excel", [
                    LaporanController::class,
                    "exportHonorariumExcel",
                ])->name("honorarium.excel");

                Route::get("/honorarium/export-pdf", [
                    LaporanController::class,
                    "exportHonorariumPdf",
                ])->name("honorarium.pdf");

                // Slip
                Route::get("/slip/{honorarium}", [
                    LaporanController::class,
                    "slipGaji",
                ])->name("slip");
            });
    });

// ============================================================
// KARYAWAN ROUTES
// ============================================================

Route::middleware(["auth", "role:karyawan"])
    ->prefix("karyawan")
    ->name("karyawan.")
    ->group(function () {
        // Dashboard
        Route::get("/dashboard", [
            DashboardController::class,
            "karyawan",
        ])->name("dashboard");

        // Presensi
        Route::prefix("presensi")
            ->name("presensi.")
            ->group(function () {
                Route::get("/", [PresensiController::class, "index"])->name(
                    "index"
                );
                Route::post("/masuk", [
                    PresensiController::class,
                    "absenMasuk",
                ])->name("masuk");

                Route::get("/riwayat", [
                    PresensiController::class,
                    "riwayat",
                ])->name("riwayat");
            });

        // Izin
        Route::prefix("izin")
            ->name("izin.")
            ->group(function () {
                Route::get("/", [IzinController::class, "index"])->name(
                    "index",
                );
                Route::get("/buat", [IzinController::class, "create"])->name(
                    "create",
                );
                Route::post("/", [IzinController::class, "store"])->name(
                    "store",
                );
            });

        // Honorarium
        Route::get("/honorarium", [HonorariumController::class, "milik"])->name(
            "honorarium.index",
        );
    });
