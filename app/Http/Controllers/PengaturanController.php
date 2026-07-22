<?php

namespace App\Http\Controllers;

use App\Models\PengaturanGaji;
use App\Models\PengaturanLokasi;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    // Pengaturan gaji
    public function gaji()
    {
        $data = PengaturanGaji::all();
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
}
