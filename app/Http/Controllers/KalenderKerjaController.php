<?php

namespace App\Http\Controllers;

use App\Models\KalenderKerja;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KalenderKerjaController extends Controller
{
    /**
     * Menampilkan kalender kerja.
     */
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? Carbon::now()->month;
        $tahun = $request->tahun ?? Carbon::now()->year;

        $kalender = KalenderKerja::whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        return view(
            'admin.kalender-kerja.index',
            compact('kalender', 'bulan', 'tahun')
        );
    }

    /**
     * Generate kalender kerja (default Senin–Jumat).
     */
    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $tanggal = Carbon::create($tahun, $bulan, 1);
        $akhirBulan = $tanggal->copy()->endOfMonth();

        while ($tanggal <= $akhirBulan) {

            KalenderKerja::updateOrCreate(
                [
                    'tanggal' => $tanggal->toDateString(),
                ],
                [
                    // Senin (1) - Jumat (5)
                    'is_hari_kerja' => $tanggal->dayOfWeekIso <= 5,
                    'keterangan' => null,
                ]
            );

            $tanggal->addDay();
        }

        return back()->with(
            'success',
            'Kalender kerja berhasil digenerate.'
        );
    }

    public function update(Request $request, KalenderKerja $kalenderKerja)
    {
        if ($request->has('keterangan')) {

            $kalenderKerja->update([
                'keterangan' => $request->keterangan,
            ]);
        } else {

            $kalenderKerja->update([
                'is_hari_kerja' => (bool) $request->input('is_hari_kerja'),
            ]);
        }

        return back()->with(
            'success',
            'Kalender kerja berhasil diperbarui.'
        );
    }
}
