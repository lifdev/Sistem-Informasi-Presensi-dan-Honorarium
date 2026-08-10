<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Presensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\LogAktivitas;

class IzinController extends Controller
{
    // Form pengajuan izin (Karyawan)
    public function create()
    {
        return view('karyawan.izin.create');
    }

    // Simpan pengajuan izin
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_mulai'   => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jenis'           => 'required|in:izin,sakit',
            'alasan'          => 'required|string|max:500',
            'lampiran'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();
        $karyawan = $user->karyawan;

        $lampiranPath = null;
        if ($request->hasFile('lampiran')) {
            $lampiranPath = $request->file('lampiran')->store('lampiran_izin', 'public');
        }

        Izin::create([
            'karyawan_id'     => $karyawan->id,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'jenis'           => $request->jenis,
            'alasan'          => $request->alasan,
            'lampiran'        => $lampiranPath,
            'status'          => 'pending',
        ]);

        LogAktivitas::catat('ajukan_izin', "Mengajukan {$request->jenis} ({$karyawan->nama}).");

        return redirect()->route('karyawan.izin.index')
            ->with('success', 'Pengajuan izin berhasil dikirim.');
    }

    // Daftar izin karyawan sendiri
    public function index()
    {
        $user = Auth::user();
        $karyawan = $user->karyawan;

        $izin = Izin::where('karyawan_id', $karyawan->id)
            ->latest()->paginate(10);

        return view('karyawan.izin.index', compact('izin'));
    }

    // Daftar izin pending (Pimpinan/Admin)
    public function approval()
    {
        $user = Auth::user();

        $izin = Izin::with('karyawan')
            ->where('status', 'pending')
            // Jangan tampilkan izin milik sendiri di daftar approval
            ->where('karyawan_id', '!=', $user->karyawan?->id)
            ->latest()->paginate(10);

        return view('pimpinan.izin.approval', compact('izin'));
    }

    // Setujui izin
    public function approve(Izin $izin)
    {
        $user = Auth::user();

        // Cegah approve izin milik sendiri
        if ($user->karyawan && $izin->karyawan_id === $user->karyawan->id) {
            return back()->with('error', 'Anda tidak dapat menyetujui izin milik Anda sendiri.');
        }

        $izin->update([
            'status'        => 'disetujui',
            'disetujui_oleh' => Auth::id(),
            'disetujui_at'  => Carbon::now(),
        ]);

        // Update status presensi untuk tanggal izin
        $this->updatePresensiIzin($izin);

        LogAktivitas::catat('approve_izin', "Menyetujui izin milik {$izin->karyawan->nama}.");

        return back()->with('success', 'Izin berhasil disetujui.');
    }

    // Tolak izin
    public function reject(Izin $izin)
    {
        $user = Auth::user();

        // Cegah reject izin milik sendiri
        if ($user->karyawan && $izin->karyawan_id === $user->karyawan->id) {
            return back()->with('error', 'Anda tidak dapat menolak izin milik Anda sendiri.');
        }

        $izin->update([
            'status'            => 'ditolak',
            'disetujui_oleh'    => Auth::id(),
            'disetujui_at'      => Carbon::now(),
        ]);

        LogAktivitas::catat('reject_izin', "Menolak izin milik {$izin->karyawan->nama}.");

        return back()->with('success', 'Izin berhasil ditolak.');
    }

    // Update presensi otomatis setelah izin disetujui
    private function updatePresensiIzin(Izin $izin): void
    {
        $start = Carbon::parse($izin->tanggal_mulai);
        $end   = Carbon::parse($izin->tanggal_selesai);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            Presensi::updateOrCreate(
                ['karyawan_id' => $izin->karyawan_id, 'tanggal' => $date->toDateString()],
                ['status' => $izin->jenis, 'keterangan' => $izin->alasan]
            );
        }
    }
}
