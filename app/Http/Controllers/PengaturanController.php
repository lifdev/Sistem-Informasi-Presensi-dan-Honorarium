<?php

namespace App\Http\Controllers;

use App\Models\PengaturanHonorarium;
use App\Models\PengaturanLokasi;
use Illuminate\Http\Request;
use App\Models\PengaturanJam;
use App\Models\KalenderKerja;

class PengaturanController extends Controller
{
    // Pengaturan honorarium
    public function honorarium()
    {
        $data = PengaturanHonorarium::with('jabatan.bidang')
            ->orderBy('jabatan_id')
            ->get();

        return view('admin.pengaturan.honorarium', compact('data'));
    }

    public function updateHonorarium(Request $request, PengaturanHonorarium $pengaturanHonorarium)
    {
        $request->validate([
            'tipe' => 'required|in:bulanan,per_hadir',
            'honorarium_pokok' => 'required_if:tipe,bulanan|nullable|numeric|min:0',
            'tarif_per_hadir' => 'required_if:tipe,per_hadir|nullable|numeric|min:0',
        ]);

        // Tipe "per_hadir" untuk relawan guru / ustad part-time:
        // dibayar tarif x jumlah hari hadir, tanpa potongan alpha
        // (hari tidak hadir memang tidak dibayar).
        if ($request->tipe === 'per_hadir') {
            $pengaturanHonorarium->update([
                'tipe' => 'per_hadir',
                'tarif_per_hadir' => $request->tarif_per_hadir,
                'honorarium_pokok' => 0,
                'potongan_alpha' => 0,
            ]);

            return back()->with('success', 'Pengaturan honorarium berhasil diperbarui.');
        }

        // Tipe "bulanan" untuk karyawan tetap: honorarium flat per bulan.
        $jumlahHariKerja = KalenderKerja::where('is_hari_kerja', true)
            ->whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Potongan alpha = 100% honorarium harian, dihitung otomatis dari honorarium_pokok
        // dibagi jumlah hari kerja bulan berjalan (bukan input manual)
        $potonganAlpha = $jumlahHariKerja > 0
            ? round($request->honorarium_pokok / $jumlahHariKerja)
            : 0;

        // Catatan: bonus TIDAK diatur di sini lagi. Bonus bersifat
        // tidak rutin dan per individu, sehingga diinput langsung
        // per karyawan di halaman Detail Honorarium tiap bulan.
        $pengaturanHonorarium->update([
            'tipe' => 'bulanan',
            'honorarium_pokok' => $request->honorarium_pokok,
            'potongan_alpha' => $potonganAlpha,
            'tarif_per_hadir' => 0,
        ]);

        return back()->with('success', 'Pengaturan honorarium berhasil diperbarui.');
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
