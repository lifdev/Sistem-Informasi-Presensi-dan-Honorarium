<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanGaji;

class PengaturanGajiSeeder extends Seeder
{
    public function run(): void
    {
        // Delete
        \App\Models\PengaturanGaji::truncate();

        $data = [
            [
                "jabatan" => "Admin",
                "gaji_pokok" => 4000000,
                "tunjangan_hadir" => 50000,
                "potongan_alpha" => 100000,
                "potongan_izin" => 50000,
                "potongan_sakit" => 25000,
            ],
            [
                "jabatan" => "Ketua Yayasan",
                "gaji_pokok" => 7000000,
                "tunjangan_hadir" => 100000,
                "potongan_alpha" => 200000,
                "potongan_izin" => 100000,
                "potongan_sakit" => 50000,
            ],
            [
                "jabatan" => "Staff",
                "gaji_pokok" => 3000000,
                "tunjangan_hadir" => 30000,
                "potongan_alpha" => 75000,
                "potongan_izin" => 37500,
                "potongan_sakit" => 20000,
            ],
        ];

        foreach ($data as $item) {
            PengaturanGaji::create($item);
        }
    }
}
