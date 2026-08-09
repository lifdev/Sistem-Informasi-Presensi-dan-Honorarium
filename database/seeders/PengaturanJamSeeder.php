<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanJam;

class PengaturanJamSeeder extends Seeder
{
    public function run(): void
    {
        PengaturanJam::create([
            'jam_masuk_mulai'   => '07:00:00',
            'jam_masuk_selesai' => '08:00:00',
            'aktif'             => true,
        ]);
    }
}
