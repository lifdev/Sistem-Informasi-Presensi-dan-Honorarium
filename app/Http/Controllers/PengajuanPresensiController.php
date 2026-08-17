<?php

namespace App\Http\Controllers;

use App\Models\PengajuanPresensi;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class PengajuanPresensiController extends Controller
{
    // Form pengajuan presensi susulan (Karyawan)
    public function create()
    {
        return view('karyawan.presensi.pengajuan.create');
    }

    // Simpan pengajuan presensi susulan
    public function store(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date|before_or_equal:today',
            'jam_masuk' => 'required|date_format:H:i',
            'alasan'    => 'required|string|max:500',
            'lampiran'  => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user     = Auth::user();
        $karyawan = $user->karyawan;

        // Cegah pengajuan untuk tanggal yang sudah punya presensi (sudah absen / sudah izin)
        $sudahAdaPresensi = Presensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $request->tanggal)
            ->exists();

        if ($sudahAdaPresensi) {
            return back()->withInput()->with(
                'error',
                'Tanggal tersebut sudah memiliki data presensi. Pengajuan tidak diperlukan.'
            );
        }

        // Cegah pengajuan ganda untuk tanggal yang sama
        $sudahAdaPengajuan = PengajuanPresensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal', $request->tanggal)
            ->whereIn('status', ['pending', 'disetujui'])
            ->exists();

        if ($sudahAdaPengajuan) {
            return back()->withInput()->with(
                'error',
                'Anda sudah memiliki pengajuan presensi untuk tanggal tersebut.'
            );
        }

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_pengajuan_presensi', 'public');
        }

        PengajuanPresensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal'     => $request->tanggal,
            'jam_masuk'   => $request->jam_masuk,
            'alasan'      => $request->alasan,
            'lampiran'    => $lampiranPath,
            'status'      => 'pending',
        ]);

        LogAktivitas::catat(
            'ajukan_presensi',
            "Mengajukan presensi susulan tanggal {$request->tanggal} ({$karyawan->nama})."
        );

        return redirect()->route('karyawan.presensi.pengajuan.index')
            ->with('success', 'Pengajuan presensi susulan berhasil dikirim.');
    }

    // Daftar pengajuan presensi milik karyawan sendiri
    public function index()
    {
        $user     = Auth::user();
        $karyawan = $user->karyawan;

        $pengajuan = PengajuanPresensi::where('karyawan_id', $karyawan->id)
            ->latest('tanggal')->paginate(10);

        return view('karyawan.presensi.pengajuan.index', compact('pengajuan'));
    }

    // Daftar pengajuan pending (Pimpinan/Admin)
    public function approval()
    {
        $user = Auth::user();

        $pengajuan = PengajuanPresensi::with('karyawan')
            ->where('status', 'pending')
            // Jangan tampilkan pengajuan milik sendiri di daftar approval
            ->where('karyawan_id', '!=', $user->karyawan?->id)
            ->latest('tanggal')->paginate(10);

        return view('pimpinan.presensi.pengajuan-approval', compact('pengajuan'));
    }

    // Setujui pengajuan presensi
    public function approve(PengajuanPresensi $pengajuan)
    {
        $user = Auth::user();

        // Cegah approve pengajuan milik sendiri
        if ($user->karyawan && $pengajuan->karyawan_id === $user->karyawan->id) {
            return back()->with('error', 'Anda tidak dapat menyetujui pengajuan milik Anda sendiri.');
        }

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuan->update([
            'status'         => 'disetujui',
            'disetujui_oleh' => Auth::id(),
            'disetujui_at'   => Carbon::now(),
        ]);

        // Catat presensi hasil approval ke tabel presensi
        Presensi::updateOrCreate(
            [
                'karyawan_id' => $pengajuan->karyawan_id,
                'tanggal'     => $pengajuan->tanggal->toDateString(),
            ],
            [
                'jam_masuk'  => $pengajuan->jam_masuk,
                'status'     => 'hadir',
                'keterangan' => 'Pengajuan Susulan',
            ]
        );

        LogAktivitas::catat(
            'approve_presensi',
            "Menyetujui pengajuan presensi susulan milik {$pengajuan->karyawan->nama} tanggal {$pengajuan->tanggal->format('d/m/Y')}."
        );

        return back()->with('success', 'Pengajuan presensi berhasil disetujui.');
    }

    // Tolak pengajuan presensi
    public function reject(PengajuanPresensi $pengajuan)
    {
        $user = Auth::user();

        // Cegah reject pengajuan milik sendiri
        if ($user->karyawan && $pengajuan->karyawan_id === $user->karyawan->id) {
            return back()->with('error', 'Anda tidak dapat menolak pengajuan milik Anda sendiri.');
        }

        if ($pengajuan->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $pengajuan->update([
            'status'         => 'ditolak',
            'disetujui_oleh' => Auth::id(),
            'disetujui_at'   => Carbon::now(),
        ]);

        LogAktivitas::catat(
            'reject_presensi',
            "Menolak pengajuan presensi susulan milik {$pengajuan->karyawan->nama} tanggal {$pengajuan->tanggal->format('d/m/Y')}."
        );

        return back()->with('success', 'Pengajuan presensi berhasil ditolak.');
    }
}
