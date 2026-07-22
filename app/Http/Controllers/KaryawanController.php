<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::with('user')->latest()->paginate(10);
        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('admin.karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|unique:karyawan,nip',
            'nama'          => 'required|string|max:100',
            'jabatan'       => 'required|string',
            'departemen'    => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'role'          => 'required|in:admin,karyawan,pimpinan',
        ]);

        $karyawan = Karyawan::create($request->only([
            'nip',
            'nama',
            'jabatan',
            'departemen',
            'jenis_kelamin',
            'no_hp',
            'alamat',
            'tanggal_masuk',
        ]));

        User::create([
            'name'        => $request->nama,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'role'        => $request->role,
            'karyawan_id' => $karyawan->id,
        ]);

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('admin.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nip'           => 'required|unique:karyawan,nip,' . $karyawan->id,
            'nama'          => 'required|string|max:100',
            'jabatan'       => 'required|string',
            'departemen'    => 'nullable|string',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
        ]);

        $karyawan->update($request->only([
            'nip',
            'nama',
            'jabatan',
            'departemen',
            'jenis_kelamin',
            'no_hp',
            'alamat',
            'tanggal_masuk',
            'status',
        ]));

        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->user()->delete();
        $karyawan->delete();
        return redirect()->route('admin.karyawan.index')
            ->with('success', 'Karyawan berhasil dihapus.');
    }
}
