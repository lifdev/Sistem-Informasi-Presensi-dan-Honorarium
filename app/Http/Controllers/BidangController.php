<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $bidangs = Bidang::with('jabatan.karyawan')->get();

        return view('admin.bidang.index', compact('bidangs'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('admin.bidang.create');
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:bidang,nama',
            'deskripsi' => 'nullable|string',
        ]);

        Bidang::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit(Bidang $bidang)
    {
        return view('admin.bidang.edit', compact('bidang'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Bidang $bidang)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:bidang,nama,' . $bidang->id,
            'deskripsi' => 'nullable|string',
        ]);

        $bidang->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Bidang $bidang)
    {
        if ($bidang->jabatan()->exists()) {
            return redirect()
                ->route('admin.bidang.index')
                ->with('error', 'Bidang tidak dapat dihapus karena masih memiliki data jabatan.');
        }

        $bidang->delete();

        return redirect()
            ->route('admin.bidang.index')
            ->with('success', 'Bidang berhasil dihapus.');
    }
}
