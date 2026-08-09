<?php

namespace App\Http\Controllers;

use App\Models\PengaturanGaji;
use App\Models\PengaturanLokasi;
use Illuminate\Http\Request;
use App\Models\PengaturanJam;
use App\Models\KalenderKerja;

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
            'gaji_pokok' => 'required|numeric|min:0',
            'bonus' => 'required|numeric|min:0',
        ]);

        $jumlahHariKerja = KalenderKerja::where('is_hari_kerja', true)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Potongan alpha = 100% gaji harian, dihitung otomatis dari gaji_pokok
        // dibagi jumlah hari kerja bulan berjalan (bukan input manual)
        $potonganAlpha = $jumlahHariKerja > 0
            ? round($request->gaji_pokok / $jumlahHariKerja)
            : 0;

        $pengaturanGaji->update([
            'gaji_pokok' => $request->gaji_pokok,
            'bonus' => $request->bonus,
            'potongan_alpha' => $potonganAlpha,
        ]);

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
            'jam_masuk_mulai'   => 'required',
            'jam_masuk_selesai' => 'required|after:jam_masuk_mulai',
        ], [
            'jam_masuk_selesai.after' => 'Batas akhir absen masuk harus setelah jam mulai masuk.',
        ]);

        $jam = PengaturanJam::aktif();
        if ($jam) {
            $jam->update($request->only([
                'jam_masuk_mulai',
                'jam_masuk_selesai',
            ]));
        } else {
            PengaturanJam::create($request->only([
                'jam_masuk_mulai',
                'jam_masuk_selesai',
            ]) + ['aktif' => true]);
        }

        return back()->with('success', 'Pengaturan jam kerja berhasil diperbarui.');
    }
}
