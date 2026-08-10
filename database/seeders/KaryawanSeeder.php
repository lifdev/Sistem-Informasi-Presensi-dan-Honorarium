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

        // Ambil jabatan yang sudah ada
        $adminJabatan = Jabatan::where("nama", "Web Developer")->first();
        $taufikJabatan = Jabatan::where("nama", "Kepala Administrasi")->first();
        $pimpinanJabatan = Jabatan::where("nama", "Ketua Yayasan")->first();

        if (!$adminJabatan || !$taufikJabatan || !$pimpinanJabatan) {
            throw new \Exception(
                "Pastikan JabatanSeeder sudah dijalankan dan nama jabatan sesuai."
            );
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN - ALIF
        |--------------------------------------------------------------------------
        */

        $admin = Karyawan::create([
            "nip" => "ADM001",
            "nama" => "Alif",
            "jabatan_id" => $adminJabatan->id,
            "jenis_kelamin" => "L",
            "no_hp" => "081234567892",
            "alamat" => "Kantor Yayasan",
            "tanggal_masuk" => "2026-01-01",
            "status" => "aktif",
        ]);

        User::create([
            "name" => $admin->nama,
            "email" => "alif@gmail.com",
            "password" => Hash::make("password"),
            "role" => "admin",
            "karyawan_id" => $admin->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | ADMIN - TAUFIK HIDAYAT
        |--------------------------------------------------------------------------
        */

        $taufik = Karyawan::create([
            "nip" => "ADM002",
            "nama" => "Taufik Hidayat",
            "jabatan_id" => $taufikJabatan->id,
            "jenis_kelamin" => "L",
            "no_hp" => null,
            "alamat" => null,
            "tanggal_masuk" => "2026-01-01",
            "status" => "aktif",
        ]);

        User::create([
            "name" => $taufik->nama,
            "email" => "taufik@gmail.com",
            "password" => Hash::make("password"),
            "role" => "admin",
            "karyawan_id" => $taufik->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PIMPINAN
        |--------------------------------------------------------------------------
        */

        $pimpinan = Karyawan::create([
            "nip" => "PIM001",
            "nama" => "KH. M. Fazary Ash Shofa, S.Ag., M.Ag",
            "jabatan_id" => $pimpinanJabatan->id,
            "jenis_kelamin" => "L",
            "no_hp" => null,
            "alamat" => null,
            "tanggal_masuk" => "2026-01-01",
            "status" => "aktif",
        ]);

        User::create([
            "name" => $pimpinan->nama,
            "email" => "fazary@gmail.com",
            "password" => Hash::make("password"),
            "role" => "pimpinan",
            "karyawan_id" => $pimpinan->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | KARYAWAN
        |--------------------------------------------------------------------------
        */

        $data = [

            // ============================================================
            // YAYASAN
            // ============================================================
            //
            // Ketua Yayasan (KH. M. Fazary Ash Shofa) tidak dimasukkan di sini
            // karena sudah dibuat sebagai PIMPINAN.
            //

            [
                "nama" => "KH. Ahmad Fauzi, S.Pd.I",
                "jabatan" => "Ketua Pembina Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Hj. Siti Aisyah, S.Ag",
                "jabatan" => "Anggota Pembina Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "KH. Abdul Karim",
                "jabatan" => "Ketua Pengawas Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ust. Maulana Ibrahim",
                "jabatan" => "Anggota Pengawas Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Hj. Khairunnisa, S.Ag",
                "jabatan" => "Wakil Ketua Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Muhammad Rizki, S.E",
                "jabatan" => "Sekretaris Umum Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ahmad Syukron",
                "jabatan" => "Wakil Sekretaris Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Siti Rahmawati, S.Ak",
                "jabatan" => "Bendahara Umum Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Dewi Lestari",
                "jabatan" => "Wakil Bendahara Yayasan",
                "jenis_kelamin" => "P",
            ],

            // ============================================================
            // BIDANG PENDIDIKAN
            // ============================================================

            [
                "nama" => "Hj. Yuniawati Fajriah, S.Pd., M.Pd",
                "jabatan" => "Kepala Sekolah PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Nurul Hidayah, S.Pd",
                "jabatan" => "Wakil Kepala Sekolah PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Annisa Nurul Fiqroh, S.Pd",
                "jabatan" => "Guru PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Nabila Salsabila, S.Pd",
                "jabatan" => "Guru PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Raihana Jahra Safinatunajah, S.Pd",
                "jabatan" => "Guru PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Rifda Khairunnisa, S.Pd",
                "jabatan" => "Guru PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Maya Dwi Anggraini, S.Pd",
                "jabatan" => "Guru PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ade Ayu Ningtyas, S.Pd",
                "jabatan" => "Guru Pendamping PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Alfi Nur Nisaun Nabila",
                "jabatan" => "Operator PAUD",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Agus Prasetyo",
                "jabatan" => "Staf Administrasi PAUD",
                "jenis_kelamin" => "L",
            ],

            // ============================================================
            // BIDANG MAJELIS QUR'AN SAUNG HIJAIYAH
            // ============================================================

            [
                "nama" => "KH. M. Faturrohman",
                "jabatan" => "Pembina Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ust. Ahmad Zainuddin",
                "jabatan" => "Ketua Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Siti Aminah",
                "jabatan" => "Wakil Ketua Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ust. Abdul Malik",
                "jabatan" => "Koordinator Tahsin Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Nisa Rahmah",
                "jabatan" => "Koordinator Tahfidz Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ust. Hasan Basri",
                "jabatan" => "Pengajar Tahsin Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ust. Farhan",
                "jabatan" => "Pengajar Al-Qur'an Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Lina Safitri",
                "jabatan" => "Pengajar Tahfidz Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ustadzah Maryam",
                "jabatan" => "Pengajar Al-Qur'an Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ahmad Fauzan",
                "jabatan" => "Sekretaris Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "L",
            ],

            // ============================================================
            // BIDANG UNIT SOSIAL
            // ============================================================

            [
                "nama" => "Agus Miswanto",
                "jabatan" => "Penanggung Jawab Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Roni Saputra",
                "jabatan" => "Koordinator Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Riben Bayu",
                "jabatan" => "Sopir Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Galih Permana",
                "jabatan" => "Sopir Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Arif Rahman",
                "jabatan" => "Sopir Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Rizal Ramadhan",
                "jabatan" => "Tim Medis Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Andi Pratama",
                "jabatan" => "Tim Medis Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Wahyu Hidayat",
                "jabatan" => "Staf Logistik Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Dadan Rohiman",
                "jabatan" => "Teknisi Ambulans",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Sandi Maulana",
                "jabatan" => "Relawan Ambulans",
                "jenis_kelamin" => "L",
            ],

            // ============================================================
            // PENGAJIAN ORANG DEWASA
            // ============================================================

            [
                "nama" => "KH. Ahmad Basyaiban",
                "jabatan" => "Penasehat Pengajian",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ust. Ahmad Ridho",
                "jabatan" => "Ketua Pengajian",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Syarifah",
                "jabatan" => "Wakil Ketua Pengajian",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ust. Lukman",
                "jabatan" => "Penceramah",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Fatimah",
                "jabatan" => "Penceramah",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ust. Ali Imron",
                "jabatan" => "Koordinator Kajian",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Masruroh",
                "jabatan" => "Sekretaris Pengajian",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ustadzah Nuraini",
                "jabatan" => "Bendahara Pengajian",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ust. Iwan Setiawan",
                "jabatan" => "Sie Perlengkapan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ust. Rudi Hartono",
                "jabatan" => "Sie Konsumsi",
                "jenis_kelamin" => "L",
            ],

            // ============================================================
            // BIDANG SOSIAL & HUMAS
            // ============================================================

            [
                "nama" => "Muhammad Arif",
                "jabatan" => "Kepala Bidang Sosial",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Siti Nurfadhilah",
                "jabatan" => "Staf Sosial",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ahmad Rizal",
                "jabatan" => "Koordinator Santunan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Dewi Sartika",
                "jabatan" => "Koordinator Donatur",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Rina Kusuma",
                "jabatan" => "Humas Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Farhan Akbar",
                "jabatan" => "Media & Publikasi",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Deni Kurniawan",
                "jabatan" => "Dokumentasi",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Aulia Rahman",
                "jabatan" => "Admin Media Sosial",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Fariz Nurrahim",
                "jabatan" => "IT Support",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Yuni Lestari",
                "jabatan" => "Customer Service Yayasan",
                "jenis_kelamin" => "P",
            ],

            // ============================================================
            // BIDANG ADMINISTRASI & UMUM
            // ============================================================
            //
            // Taufik tidak dimasukkan di sini karena sudah dibuat
            // sebagai ADMIN dengan jabatan Kepala Administrasi.
            //

            [
                "nama" => "Siti Maemunah",
                "jabatan" => "Staf Administrasi",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Rika Amalia",
                "jabatan" => "Arsiparis",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Indra Gunawan",
                "jabatan" => "Staf Umum",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Agus Salim",
                "jabatan" => "Petugas Kebersihan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Yanto",
                "jabatan" => "Petugas Keamanan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Sumarni",
                "jabatan" => "Petugas Dapur",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Roni Wijaya",
                "jabatan" => "Logistik Umum",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Hendra Setiawan",
                "jabatan" => "Maintenance Gedung",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Lina Puspita",
                "jabatan" => "Inventaris Yayasan",
                "jenis_kelamin" => "P",
            ],

            // ============================================================
            // BIDANG RELAWAN & PENDUKUNG
            // ============================================================

            [
                "nama" => "Ahmad Fikri",
                "jabatan" => "Koordinator Relawan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Siti Zahra",
                "jabatan" => "Relawan Pendidikan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Muhammad Iqbal",
                "jabatan" => "Relawan Sosial Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Rahmat Hidayat",
                "jabatan" => "Relawan Ambulans Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Laila Nur",
                "jabatan" => "Relawan Majelis Qur'an Saung Hijaiyah",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Naufal Arif",
                "jabatan" => "Relawan IT Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Nisa Fitriani",
                "jabatan" => "Relawan Media Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Dwi Saputra",
                "jabatan" => "Relawan Lapangan Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Putri Anjani",
                "jabatan" => "Relawan Acara Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Rizky Pratama",
                "jabatan" => "Relawan Logistik Yayasan",
                "jenis_kelamin" => "L",
            ],

            // ============================================================
            // PENASEHAT & PENGEMBANGAN
            // ============================================================

            [
                "nama" => "KH. Abdullah Syafi'i",
                "jabatan" => "Penasehat Spiritual Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "H. Rachmat",
                "jabatan" => "Penasehat Sosial Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Hj. Salmah",
                "jabatan" => "Penasehat Pendidikan Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ust. Rahman",
                "jabatan" => "Tokoh Masyarakat Mitra Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Ustadzah Heni",
                "jabatan" => "Tokoh Muslimah Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "H. Darman",
                "jabatan" => "Donatur Tetap Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Hj. Yuliana",
                "jabatan" => "Donatur Tetap Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Ahmad Sholeh",
                "jabatan" => "Mitra Sosial Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Budi Santoso",
                "jabatan" => "Mitra Pendidikan Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Rina Wulandari",
                "jabatan" => "Mitra Kesehatan Yayasan",
                "jenis_kelamin" => "P",
            ],

            // ============================================================
            // UNIT PENGEMBANGAN YAYASAN
            // ============================================================

            [
                "nama" => "Muhammad Fajar",
                "jabatan" => "Kepala Unit Usaha Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Siti Khairunnisa",
                "jabatan" => "Pengembangan SDM Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Andri Firmansyah",
                "jabatan" => "Audit Internal Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Lutfiah",
                "jabatan" => "Monitoring & Evaluasi Program Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Arif Budiman",
                "jabatan" => "Perencanaan Program Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Sulaiman",
                "jabatan" => "Pengadaan Barang Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Fitria Dewi",
                "jabatan" => "Pelayanan Jamaah Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Asep Kurnia",
                "jabatan" => "Koordinator Lapangan Yayasan",
                "jenis_kelamin" => "L",
            ],
            [
                "nama" => "Yuni Astuti",
                "jabatan" => "Administrasi Program Yayasan",
                "jenis_kelamin" => "P",
            ],
            [
                "nama" => "Rian Maulana",
                "jabatan" => "Staf Pendukung Yayasan",
                "jenis_kelamin" => "L",
            ],
        ];

        /*
        |--------------------------------------------------------------------------
        | CREATE KARYAWAN
        |--------------------------------------------------------------------------
        */

        $nomor = 1;

        foreach ($data as $item) {

            $jabatan = Jabatan::where("nama", $item["jabatan"])->first();

            if (!$jabatan) {
                throw new \Exception(
                    "Jabatan '{$item["jabatan"]}' untuk '{$item["nama"]}' tidak ditemukan. " .
                        "Pastikan JabatanSeeder sudah dijalankan dan nama jabatan sesuai."
                );
            }

            $karyawan = Karyawan::create([
                "nip" => "KRY" . str_pad($nomor, 3, "0", STR_PAD_LEFT),
                "nama" => $item["nama"],
                "jabatan_id" => $jabatan->id,
                "jenis_kelamin" => $item["jenis_kelamin"],
                "no_hp" => null,
                "alamat" => null,
                "tanggal_masuk" => "2026-01-01",
                "status" => "aktif",
            ]);

            User::create([
                "name" => $karyawan->nama,
                "email" => "karyawan" . $nomor . "@gmail.com",
                "password" => Hash::make("password"),
                "role" => "karyawan",
                "karyawan_id" => $karyawan->id,
            ]);

            $nomor++;
        }
    }
}
