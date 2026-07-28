<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanGaji;

class PengaturanGajiSeeder extends Seeder
{
    public function run(): void
    {
    PengaturanGaji::truncate();

    $jabatans = \App\Models\Jabatan::all();

    foreach ($jabatans as $jabatan) {

        PengaturanGaji::create([

            'jabatan_id' => $jabatan->id,

            'gaji_pokok' => 0,
            'tunjangan_hadir' => 0,
            'potongan_alpha' => 0,
            'potongan_izin' => 0,
            'potongan_sakit' => 0,

            ]);

        }
    }
}
