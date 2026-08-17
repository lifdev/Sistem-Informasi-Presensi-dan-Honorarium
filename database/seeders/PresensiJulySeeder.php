<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Presensi;
use App\Models\KalenderKerja;

class PresensiJulySeeder extends Seeder
{
    public function run()
    {
        $karyawanId = 1; // php artisan db:seed --class=PresensiJulySeeder

        $hariKerja = KalenderKerja::whereBetween('tanggal', ['2026-07-01', '2026-07-31'])
            ->where('is_hari_kerja', 1)
            ->pluck('tanggal');

        foreach ($hariKerja as $tanggal) {
            Presensi::firstOrCreate(
                [
                    'karyawan_id' => $karyawanId,
                    'tanggal' => $tanggal,
                ],
                [
                    'jam_masuk' => '08:00:00',
                    'status' => 'hadir',
                    'keterangan' => 'Test full hadir sesuai kalender kerja',
                ]
            );
        }
    }
}
