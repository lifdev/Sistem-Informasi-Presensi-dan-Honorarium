<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    // Daftar log aktivitas sistem (Admin only, diproteksi lewat route middleware role:admin)
    public function index(Request $request)
    {
        $query = LogAktivitas::with('user')->latest();

        if ($request->filled('aktivitas')) {
            $query->where('aktivitas', $request->aktivitas);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $log = $query->paginate(25)->withQueryString();

        $daftarAktivitas = LogAktivitas::select('aktivitas')
            ->distinct()
            ->orderBy('aktivitas')
            ->pluck('aktivitas');

        return view('admin.log-aktivitas.index', compact('log', 'daftarAktivitas'));
    }
}
