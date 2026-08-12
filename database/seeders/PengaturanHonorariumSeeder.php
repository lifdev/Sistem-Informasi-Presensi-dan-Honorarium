<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PengaturanHonorarium;

class PengaturanHonorariumSeeder extends Seeder
{
    public function run(): void
    {
        PengaturanHonorarium::truncate();

        $jabatans = \App\Models\Jabatan::all();

        foreach ($jabatans as $jabatan) {

            PengaturanHonorarium::create([
                'jabatan_id'     => $jabatan->id,
                'honorarium_pokok'      => 0,
                'potongan_alpha'  => 0,
            ]);
        }
    }
}
