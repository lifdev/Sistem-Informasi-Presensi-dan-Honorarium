<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Jabatan;
use App\Models\Bidang;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $karyawan = Karyawan::with(['user', 'jabatan.bidang'])
            ->when($search, function ($query) use ($search) {
                $query->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhereHas('jabatan', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%")
                            ->orWhereHas('bidang', function ($b) use ($search) {
                                $b->where('nama', 'like', "%{$search}%");
                            });
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        $bidangs = Bidang::orderBy('nama')->get();
        $jabatans = Jabatan::orderBy('nama')->get();

        return view('admin.karyawan.create', compact('bidangs', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'           => 'required|unique:karyawan,nip',
            'nama'          => 'required|string|max:100',
            'jabatan_id'    => 'required|exists:jabatan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'role'          => 'required|in:admin,karyawan,pimpinan',
        ]);

        $karyawan = Karyawan::create([
            'nip'            => $request->nip,
            'nama'           => $request->nama,
            'jabatan_id'     => $request->jabatan_id,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'status'         => 'aktif',
        ]);

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
        $bidangs = Bidang::orderBy('nama')->get();
        $jabatans = Jabatan::orderBy('nama')->get();

        return view('admin.karyawan.edit', compact(
            'karyawan',
            'bidangs',
            'jabatans'
        ));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nip'           => 'required|unique:karyawan,nip,' . $karyawan->id,
            'nama'          => 'required|string|max:100',
            'jabatan_id' => 'required|exists:jabatan,id',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => 'nullable|string|max:20',
            'alamat'        => 'nullable|string',
            'tanggal_masuk' => 'required|date',
            'status'        => 'required|in:aktif,nonaktif',
            'role'          => 'nullable|in:admin,karyawan,pimpinan',
        ]);

        $karyawan->update([
            'nip'            => $request->nip,
            'nama'           => $request->nama,
            'jabatan_id'     => $request->jabatan_id,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'no_hp'          => $request->no_hp,
            'alamat'         => $request->alamat,
            'tanggal_masuk'  => $request->tanggal_masuk,
            'status'         => $request->status,
        ]);

        // Update role akun terkait (kalau ada dan diisi di form)
        if ($request->filled('role') && $karyawan->user) {
            // Cegah admin mengubah role akun miliknya sendiri
            // (mencegah admin tidak sengaja mengunci akses admin sendiri)
            if ($karyawan->user->id === auth()->id()) {
                return redirect()->route('admin.karyawan.index')
                    ->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
            }

            $karyawan->user->update(['role' => $request->role]);
        }

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
