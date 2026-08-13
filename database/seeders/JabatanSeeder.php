<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bidang;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $data = [

            'Development' => [
                'Web Developer',
                'Web Developer Freelance'
            ],

        ];

        foreach ($data as $namaBidang => $jabatans) {

            $bidang = Bidang::where('nama', $namaBidang)->first();

            foreach ($jabatans as $jabatan) {

                Jabatan::create([
                    'bidang_id' => $bidang->id,
                    'nama' => $jabatan,
                ]);
            }
        }
    }
}
