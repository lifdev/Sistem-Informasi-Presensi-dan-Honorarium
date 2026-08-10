<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $bidang = [
            ['nama' => 'Yayasan'],
            ['nama' => 'Bidang Pendidikan'],
            ['nama' => "Bidang Majelis Qur'an Saung Hijaiyah"],
            ['nama' => 'Bidang Unit Sosial'],
            ['nama' => 'Pengajian Orang Dewasa'],
            ['nama' => 'Bidang Sosial & Humas'],
            ['nama' => 'Bidang Administrasi & Umum'],
            ['nama' => 'Bidang Relawan & Pendukung'],
            ['nama' => 'Penasehat & Pengembangan'],
            ['nama' => 'Unit Pengembangan Yayasan'],
            ['nama' => 'Development'],
        ];

        foreach ($bidang as $item) {
            Bidang::create($item);
        }
    }
}
