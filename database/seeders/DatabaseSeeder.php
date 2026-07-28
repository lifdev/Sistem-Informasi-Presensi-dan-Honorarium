<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PengaturanLokasiSeeder::class,

            BidangSeeder::class,
            JabatanSeeder::class,

            PengaturanGajiSeeder::class,

            KaryawanSeeder::class,
        ]);
    }
}