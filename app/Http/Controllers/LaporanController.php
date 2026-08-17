<?php

namespace App\Http\Controllers;

use App\Exports\PresensiExport;
use App\Exports\HonorariumExport;
use App\Models\Presensi;
use App\Models\Honorarium;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    // Halaman laporan
    public function index()
    {
        $bulan = request('bulan', Carbon::now()->month);
        $tahun = request('tahun', Carbon::now()->year);
        return view('admin.laporan.index', compact('bulan', 'tahun'));
    }

    // Export presensi Excel
    public function exportPresensiExcel(Request $request)
    {
        $bulan  = $request->bulan ?? Carbon::now()->month;
        $tahun  = $request->tahun ?? Carbon::now()->year;
        $bln    = \DateTime::createFromFormat('!m', $bulan)->format('F');
        return Excel::download(
            new PresensiExport($bulan, $tahun),
            "Presensi_{$bln}_{$tahun}.xlsx"
        );
    }

    // Export presensi PDF
    public function exportPresensiPdf(Request $request)
    {
        $bulan    = $request->bulan ?? Carbon::now()->month;
        $tahun    = $request->tahun ?? Carbon::now()->year;
        $presensi = Presensi::with('karyawan')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal')
            ->get();

        $namaBulan = \DateTime::createFromFormat('!m', $bulan)->format('F');

        $pdf = Pdf::loadView('admin.laporan.pdf.presensi', compact('presensi', 'namaBulan', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("Presensi_{$namaBulan}_{$tahun}.pdf");
    }

    // Export honorarium Excel
    public function exportHonorariumExcel(Request $request)
    {
        $bulan  = $request->bulan ?? Carbon::now()->month;
        $tahun  = $request->tahun ?? Carbon::now()->year;
        $bln    = \DateTime::createFromFormat('!m', $bulan)->format('F');
        return Excel::download(
            new HonorariumExport($bulan, $tahun),
            "Honorarium_{$bln}_{$tahun}.xlsx"
        );
    }

    // Export honorarium PDF
    public function exportHonorariumPdf(Request $request)
    {
        $bulan      = $request->bulan ?? Carbon::now()->month;
        $tahun      = $request->tahun ?? Carbon::now()->year;
        $honorarium = Honorarium::with('karyawan')
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->get();

        $namaBulan = \DateTime::createFromFormat('!m', $bulan)->format('F');

        $pdf = Pdf::loadView('admin.laporan.pdf.honorarium', compact('honorarium', 'namaBulan', 'tahun'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("Honorarium_{$namaBulan}_{$tahun}.pdf");
    }

    // Cetak slip honorarium
    public function slipHonorarium(Honorarium $honorarium)
    {
        $user = Auth::user();

        // Karyawan hanya boleh mengunduh slip miliknya sendiri.
        // Admin & pimpinan boleh mengunduh slip siapa saja (dicek lewat middleware role di route).
        if ($user->role === 'karyawan') {
            $karyawanId = $user->karyawan?->id;

            if (!$karyawanId || $honorarium->karyawan_id !== $karyawanId) {
                abort(403, 'Anda tidak memiliki akses ke slip honorarium ini.');
            }

            // Karyawan hanya boleh download slip yang sudah difinalisasi admin/pimpinan.
            if ($honorarium->status !== 'final') {
                abort(403, 'Slip honorarium belum bisa diunduh karena masih berstatus draft dan belum difinalisasi.');
            }
        }

        $honorarium->load('karyawan');
        $pdf = Pdf::loadView('admin.laporan.pdf.slip', compact('honorarium'))
            ->setPaper([0, 0, 595, 350]);
        return $pdf->stream("Slip_Honorarium_{$honorarium->karyawan->nip}_{$honorarium->namaBulan()}_{$honorarium->tahun}.pdf");
    }
}
