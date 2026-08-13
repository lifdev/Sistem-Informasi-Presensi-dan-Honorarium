<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use App\Models\User;
use App\Models\Jabatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        // Reset tabel
        DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        User::truncate();
        Karyawan::truncate();
        DB::statement("SET FOREIGN_KEY_CHECKS=1;");

        /*
        |--------------------------------------------------------------------------
        | ADMIN
        |--------------------------------------------------------------------------
        */

        User::create([
            "name" => "Alif",
            "email" => "alif@gmail.com",
            "password" => Hash::make("password"),
            "role" => "admin",
            "karyawan_id" => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PIMPINAN
        |--------------------------------------------------------------------------
        */

        User::create([
            "name" => "KH. M. Fazary Ash Shofa, S.Ag., M.Ag",
            "email" => "fazary@gmail.com",
            "password" => Hash::make("password"),
            "role" => "pimpinan",
            "karyawan_id" => null,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KARYAWAN
        |--------------------------------------------------------------------------
        */
    }
}
