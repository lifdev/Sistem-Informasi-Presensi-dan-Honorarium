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
            ['nama' => 'Development'],
        ];

        foreach ($bidang as $item) {
            Bidang::create($item);
        }
    }
}
