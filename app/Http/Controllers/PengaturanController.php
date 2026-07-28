<?php

namespace App\Http\Controllers;

use App\Models\PengaturanGaji;
use App\Models\PengaturanLokasi;
use Illuminate\Http\Request;
use App\Models\PengaturanJam;

class PengaturanController extends Controller
{
    // Pengaturan gaji
    public function gaji()
    {
    $data = PengaturanGaji::with('jabatan.bidang')
        ->orderBy('jabatan_id')
        ->get();

    return view('admin.pengaturan.gaji', compact('data'));
    }

    public function updateGaji(Request $request, PengaturanGaji $pengaturanGaji)
    {
        $request->validate([
            'gaji_pokok'      => 'required|numeric|min:0',
            'tunjangan_hadir' => 'required|numeric|min:0',
            'potongan_alpha'  => 'required|numeric|min:0',
            'potongan_izin'   => 'required|numeric|min:0',
            'potongan_sakit'  => 'required|numeric|min:0',
        ]);

        $pengaturanGaji->update($request->only([
            'gaji_pokok',
            'tunjangan_hadir',
            'potongan_alpha',
            'potongan_izin',
            'potongan_sakit',
        ]));

        return back()->with('success', 'Pengaturan gaji berhasil diperbarui.');
    }

    // Pengaturan lokasi GPS
    public function lokasi()
    {
        $lokasi = PengaturanLokasi::first();
        return view('admin.pengaturan.lokasi', compact('lokasi'));
    }

    public function updateLokasi(Request $request, PengaturanLokasi $pengaturanLokasi)
    {
        $request->validate([
            'nama_lokasi'  => 'required|string',
            'latitude'     => 'required|numeric',
            'longitude'    => 'required|numeric',
            'radius_meter' => 'required|integer|min:10|max:5000',
        ]);

        $pengaturanLokasi->update($request->only([
            'nama_lokasi',
            'latitude',
            'longitude',
            'radius_meter',
        ]));

        return back()->with('success', 'Pengaturan lokasi berhasil diperbarui.');
    }

    // Pengaturan Jam Presensi

    public function jam()
    {
        $jam = PengaturanJam::aktif() ?? new PengaturanJam();
        return view('admin.pengaturan.jam', compact('jam'));
    }

    public function updateJam(Request $request)
    {
        $request->validate([
            'jam_masuk_mulai'    => 'required',
            'jam_masuk_selesai'  => 'required|after:jam_masuk_mulai',
            'jam_pulang_mulai'   => 'required|after:jam_masuk_selesai',
            'jam_pulang_selesai' => 'required|after:jam_pulang_mulai',
        ], [
            'jam_masuk_selesai.after'  => 'Batas akhir masuk harus setelah jam mulai masuk.',
            'jam_pulang_mulai.after'   => 'Jam pulang harus setelah batas akhir masuk.',
            'jam_pulang_selesai.after' => 'Batas akhir pulang harus setelah jam mulai pulang.',
        ]);

        $jam = PengaturanJam::aktif();
        if ($jam) {
            $jam->update($request->only([
                'jam_masuk_mulai', 'jam_masuk_selesai',
                'jam_pulang_mulai', 'jam_pulang_selesai',
            ]));
        } else {
            PengaturanJam::create($request->only([
                'jam_masuk_mulai', 'jam_masuk_selesai',
                'jam_pulang_mulai', 'jam_pulang_selesai',
            ]) + ['aktif' => true]);
        }

        return back()->with('success', 'Pengaturan jam kerja berhasil diperbarui.');
    }
}
