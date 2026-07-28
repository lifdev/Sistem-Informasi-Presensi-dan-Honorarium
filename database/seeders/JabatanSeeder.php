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

            'Yayasan' => [
                'Ketua Pembina Yayasan',
                'Anggota Pembina Yayasan',
                'Ketua Pengawas Yayasan',
                'Anggota Pengawas Yayasan',
                'Ketua Yayasan',
                'Wakil Ketua Yayasan',
                'Sekretaris Umum Yayasan',
                'Wakil Sekretaris Yayasan',
                'Bendahara Umum Yayasan',
                'Wakil Bendahara Yayasan',
            ],

            'Bidang Pendidikan' => [
                'Kepala Sekolah PAUD',
                'Wakil Kepala Sekolah PAUD',
                'Guru PAUD',
                'Guru Pendamping PAUD',
                'Operator PAUD',
                'Staf Administrasi PAUD',
            ],

            "Bidang Majelis Qur'an Saung Hijaiyah" => [
                "Pembina Majelis Qur'an Saung Hijaiyah",
                "Ketua Majelis Qur'an Saung Hijaiyah",
                "Wakil Ketua Majelis Qur'an Saung Hijaiyah",
                "Sekretaris Majelis Qur'an Saung Hijaiyah",
                "Koordinator Tahfidz Majelis Qur'an Saung Hijaiyah",
                "Koordinator Tahsin Majelis Qur'an Saung Hijaiyah",
                "Pengajar Tahfidz Majelis Qur'an Saung Hijaiyah",
                "Pengajar Tahsin Majelis Qur'an Saung Hijaiyah",
                "Pengajar Al-Qur'an Majelis Qur'an Saung Hijaiyah",
            ],

            'Bidang Unit Sosial' => [
                'Penanggung Jawab Ambulans',
                'Koordinator Ambulans',
                'Sopir Ambulans',
                'Tim Medis Ambulans',
                'Relawan Ambulans',
                'Staf Logistik Ambulans',
                'Teknisi Ambulans',
            ],

            'Pengajian Orang Dewasa' => [
                'Penasehat Pengajian',
                'Ketua Pengajian',
                'Wakil Ketua Pengajian',
                'Sekretaris Pengajian',
                'Bendahara Pengajian',
                'Koordinator Kajian',
                'Penceramah',
                'Sie Konsumsi',
                'Sie Perlengkapan',
            ],

            'Bidang Sosial & Humas' => [
                'Kepala Bidang Sosial',
                'Koordinator Donatur',
                'Koordinator Santunan',
                'Humas Yayasan',
                'Media & Publikasi',
                'Admin Media Sosial',
                'Dokumentasi',
                'Customer Service Yayasan',
                'IT Support',
                'Staf Sosial',
            ],

            'Bidang Administrasi & Umum' => [
                'Kepala Administrasi',
                'Staf Administrasi',
                'Arsiparis',
                'Inventaris Yayasan',
                'Logistik Umum',
                'Petugas Kebersihan',
                'Petugas Keamanan',
                'Petugas Dapur',
                'Maintenance Gedung',
                'Staf Umum',
            ],

            'Bidang Relawan & Pendukung' => [
                'Koordinator Relawan',
                'Relawan Pendidikan',
                "Relawan Majelis Qur'an Saung Hijaiyah",
                'Relawan Ambulans Yayasan',
                'Relawan Sosial Yayasan',
                'Relawan Media Yayasan',
                'Relawan IT Yayasan',
                'Relawan Logistik Yayasan',
                'Relawan Acara Yayasan',
                'Relawan Lapangan Yayasan',
            ],

            'Penasehat & Pengembangan' => [
                'Penasehat Pendidikan Yayasan',
                'Penasehat Spiritual Yayasan',
                'Penasehat Sosial Yayasan',
                'Mitra Pendidikan Yayasan',
                'Mitra Kesehatan Yayasan',
                'Mitra Sosial Yayasan',
                'Tokoh Masyarakat Mitra Yayasan',
                'Tokoh Muslimah Yayasan',
                'Donatur Tetap Yayasan',
            ],

            'Unit Pengembangan Yayasan' => [
                'Kepala Unit Usaha Yayasan',
                'Perencanaan Program Yayasan',
                'Monitoring & Evaluasi Program Yayasan',
                'Pengembangan SDM Yayasan',
                'Pengadaan Barang Yayasan',
                'Administrasi Program Yayasan',
                'Koordinator Lapangan Yayasan',
                'Pelayanan Jamaah Yayasan',
                'Audit Internal Yayasan',
                'Staf Pendukung Yayasan',
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
