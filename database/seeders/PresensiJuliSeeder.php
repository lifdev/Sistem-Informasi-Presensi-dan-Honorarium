<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use App\Models\Presensi;
use App\Models\KalenderKerja;
use Carbon\Carbon;

class PresensiJuliSeeder extends Seeder
{
    /**
     * ====================================================================
     * SEEDER DATA PEMBANDING (bukan seeder presensi acak/random biasa!)
     * ====================================================================
     *
     * Tujuan: menyediakan data presensi Juli 2026 dengan angka yang
     * sudah DITENTUKAN SENDIRI (fixed, bukan random) supaya hasil
     * honorarium dari sistem bisa dihitung manual dulu dan dibandingkan
     * persis untuk membuktikan rumus perhitungan honorarium akurat.
     *
     * Skenario: Alif (Web Developer)
     *   - 20 hari Hadir
     *   - 1 hari Izin
     *   - 1 hari Sakit
     *   - 1 hari Alpha
     *   Total = 23 hari (= jumlah hari kerja Juli 2026)
     *
     * PENTING soal Bonus:
     * Bonus TIDAK LAGI otomatis diambil dari Pengaturan Honorarium per jabatan
     * (kolom itu sudah dihapus). Bonus sekarang bersifat tidak rutin dan
     * per individu, diinput manual oleh admin lewat halaman Detail
     * Honorarium SETELAH honorarium digenerate (selama status masih
     * Draft). Jadi begitu honorarium digenerate dari data presensi
     * seeder ini, bonusnya akan Rp 0 dulu.
     *
     * Hitungan manual (pembanding) — SEBELUM bonus diinput manual:
     *   Honorarium Pokok   = Rp 4.000.000
     *   Bonus        = Rp 0 (default saat generate)
     *   Potongan     = (4.000.000 / 23) x 1 Alpha = Rp 173.913
     *   Honorarium Bersih  = 4.000.000 + 0 - 173.913 = Rp 3.826.087
     *
     * Hitungan manual (pembanding) — SETELAH admin input bonus manual
     * Rp 100.000 lewat halaman Detail Honorarium:
     *   Honorarium Pokok   = Rp 4.000.000
     *   Bonus        = Rp 100.000 (diinput manual)
     *   Potongan     = Rp 173.913 (tidak berubah)
     *   Honorarium Bersih  = 4.000.000 + 100.000 - 173.913 = Rp 3.926.087
     */
    public function run(): void
    {
        $alif = Karyawan::where('nama', 'Alif')->first();

        if (!$alif) {
            throw new \Exception(
                "Karyawan 'Alif' tidak ditemukan. Pastikan KaryawanSeeder sudah dijalankan."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 1. Pastikan KalenderKerja Juli 2026 terisi (23 hari kerja weekday)
        |--------------------------------------------------------------------------
        */

        $awal  = Carbon::create(2026, 7, 1);
        $akhir = Carbon::create(2026, 7, 31);

        $tanggal = $awal->copy();
        while ($tanggal->lte($akhir)) {
            if (!$tanggal->isWeekend()) {
                KalenderKerja::firstOrCreate(
                    ['tanggal' => $tanggal->toDateString()],
                    ['is_hari_kerja' => true]
                );
            }
            $tanggal->addDay();
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Bersihkan presensi Juli 2026 milik Alif (biar seeder aman di-rerun)
        |--------------------------------------------------------------------------
        */

        Presensi::where('karyawan_id', $alif->id)
            ->whereMonth('tanggal', 7)
            ->whereYear('tanggal', 2026)
            ->delete();

        /*
        |--------------------------------------------------------------------------
        | 3. Insert presensi fixed: 20 Hadir, 1 Izin, 1 Sakit, 1 Alpha
        |--------------------------------------------------------------------------
        */

        $hariKerjaJuli = [
            '2026-07-01',
            '2026-07-02',
            '2026-07-03',
            '2026-07-06',
            '2026-07-07',
            '2026-07-08',
            '2026-07-09',
            '2026-07-10',
            '2026-07-13',
            '2026-07-14',
            '2026-07-15',
            '2026-07-16',
            '2026-07-17',
            '2026-07-20',
            '2026-07-21',
            '2026-07-22',
            '2026-07-23',
            '2026-07-24',
            '2026-07-27',
            '2026-07-28',
            '2026-07-29',
            '2026-07-30',
            '2026-07-31',
        ];

        foreach ($hariKerjaJuli as $i => $tgl) {
            if ($i < 20) {
                // 20 hari pertama: Hadir
                Presensi::create([
                    'karyawan_id' => $alif->id,
                    'tanggal'     => $tgl,
                    'jam_masuk'   => '08:00:00',
                    'status'      => 'hadir',
                ]);
            } elseif ($i === 20) {
                // Hari ke-21: Izin
                Presensi::create([
                    'karyawan_id' => $alif->id,
                    'tanggal'     => $tgl,
                    'jam_masuk'   => null,
                    'status'      => 'izin',
                    'keterangan'  => 'Izin keperluan keluarga',
                ]);
            } elseif ($i === 21) {
                // Hari ke-22: Sakit
                Presensi::create([
                    'karyawan_id' => $alif->id,
                    'tanggal'     => $tgl,
                    'jam_masuk'   => null,
                    'status'      => 'sakit',
                    'keterangan'  => 'Sakit demam',
                ]);
            } else {
                // Hari ke-23: Alpha
                Presensi::create([
                    'karyawan_id' => $alif->id,
                    'tanggal'     => $tgl,
                    'jam_masuk'   => null,
                    'status'      => 'alpha',
                ]);
            }
        }

        $this->command->info("[Data Pembanding] Presensi Juli 2026 selesai: Alif -> 20 Hadir, 1 Izin, 1 Sakit, 1 Alpha (total 23 hari kerja). Generate honorarium akan menghasilkan bonus Rp 0 (default) -- input bonus manual Rp 100.000 di halaman Detail Honorarium untuk mencocokkan hitungan pembanding di komentar seeder ini.");
    }
}
