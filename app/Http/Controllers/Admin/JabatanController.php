<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\PengaturanHonorarium;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $jabatans = Jabatan::with('bidang')
            ->orderBy('bidang_id')
            ->orderBy('nama')
            ->get();

        return view('admin.jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        $bidangs = Bidang::orderBy('nama')->get();

        return view('admin.jabatan.create', compact('bidangs'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidang,id',
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        // Simpan jabatan
        $jabatan = Jabatan::create([
            'bidang_id' => $request->bidang_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        // Otomatis buat pengaturan honorarium
        PengaturanHonorarium::firstOrCreate(
            ['jabatan_id' => $jabatan->id],
            [
                'tipe'             => 'bulanan',
                'honorarium_pokok' => 0,
                'potongan_alpha'   => 0,
                'tarif_per_hadir'  => 0,
            ]
        );

        return redirect()
            ->route('admin.jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Jabatan $jabatan)
    {
        $bidangs = Bidang::orderBy('nama')->get();

        return view('admin.jabatan.edit', compact('jabatan', 'bidangs'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'bidang_id' => 'required|exists:bidang,id',
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        $jabatan->update($request->all());

        return redirect()
            ->route('admin.jabatan.index')
            ->with('success', 'Jabatan berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Jabatan $jabatan)
    {
        // Tidak boleh dihapus jika masih dipakai karyawan
        if ($jabatan->karyawan()->exists()) {
            return back()->with(
                'error',
                'Jabatan tidak dapat dihapus karena masih digunakan oleh karyawan.'
            );
        }

        // Hapus pengaturan honorarium yang terkait
        $jabatan->pengaturanHonorarium()->delete();

        // Hapus jabatan
        $jabatan->delete();

        return back()->with(
            'success',
            'Jabatan berhasil dihapus.'
        );
    }
}
