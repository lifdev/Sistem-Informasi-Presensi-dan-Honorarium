<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    public function run(): void
    {
        // Delete
        \Illuminate\Support\Facades\DB::statement("SET FOREIGN_KEY_CHECKS=0;");
        \App\Models\User::truncate();
        \App\Models\Karyawan::truncate();
        \Illuminate\Support\Facades\DB::statement("SET FOREIGN_KEY_CHECKS=1;");

        // --- Admin ---
        $admin = Karyawan::create([
            "nip" => "ADM001",
            "nama" => "Alif",
            "jabatan" => "Admin",
            "departemen" => "HRD",
            "jenis_kelamin" => "L",
            "no_hp" => "08123456789",
            "alamat" => "Kantor Pusat",
            "tanggal_masuk" => "2020-01-01",
            "status" => "aktif",
        ]);

        User::create([
            "name" => "Alif",
            "email" => "alif@gmail.com",
            "password" => Hash::make("password"),
            "role" => "admin",
            "karyawan_id" => $admin->id,
        ]);

        // --- Pimpinan ---
        $pimpinan = Karyawan::create([
            "nip" => "PIM001",
            "nama" => "Budi Santoso",
            "jabatan" => "Ketua Yayasan",
            "departemen" => "Operasional",
            "jenis_kelamin" => "L",
            "no_hp" => "08234567890",
            "alamat" => "Jl. Merdeka No. 1",
            "tanggal_masuk" => "2021-03-01",
            "status" => "aktif",
        ]);

        User::create([
            "name" => "Budi Santoso",
            "email" => "budi@gmail.com",
            "password" => Hash::make("password"),
            "role" => "pimpinan",
            "karyawan_id" => $pimpinan->id,
        ]);

        // --- Karyawan 1 ---
        $k1 = Karyawan::create([
            "nip" => "KRY001",
            "nama" => "Siti Rahayu",
            "jabatan" => "Staff",
            "departemen" => "Keuangan",
            "jenis_kelamin" => "P",
            "no_hp" => "08345678901",
            "alamat" => "Jl. Mawar No. 5",
            "tanggal_masuk" => "2022-06-01",
            "status" => "aktif",
        ]);

        User::create([
            "name" => "Siti Rahayu",
            "email" => "siti@gmail.com",
            "password" => Hash::make("password"),
            "role" => "karyawan",
            "karyawan_id" => $k1->id,
        ]);
    }
}
