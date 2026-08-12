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

            PengaturanHonorariumSeeder::class,

            KaryawanSeeder::class,

            // PresensiSeeder::class, //seeder presensi hapus jika database seeder dihapus
        ]);
    }
}
