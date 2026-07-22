<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanLokasi;

class PengaturanLokasiSeeder extends Seeder
{
    public function run(): void
    {
        // Delete
        \App\Models\PengaturanLokasi::truncate();

        // Koordinat lokasi kantor
        PengaturanLokasi::create([
            "nama_lokasi" => "Kantor Pusat",
            "latitude" => -6.2, //  lat kantor
            "longitude" => 106.816666, // lng kantor
            "radius_meter" => 100,
            "aktif" => true,
        ]);
    }
}
