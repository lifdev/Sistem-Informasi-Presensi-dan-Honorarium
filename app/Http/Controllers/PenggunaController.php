<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->search);

        $pengguna = User::with(['karyawan.jabatan.bidang'])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%")
                        ->orWhereHas('karyawan', function ($k) use ($search) {
                            $k->where('nip', 'like', "%{$search}%")
                                ->orWhere('nama', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        $bidangs = Bidang::orderBy('nama')->get();
        $jabatans = Jabatan::orderBy('nama')->get();

        return view('admin.pengguna.create', compact('bidangs', 'jabatans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['admin', 'karyawan', 'pimpinan'])],

            'nip' => ['required_if:role,karyawan', 'nullable', 'string', 'max:50', 'unique:karyawan,nip'],
            'jabatan_id' => ['required_if:role,karyawan', 'nullable', 'exists:jabatan,id'],
            'honorarium_tipe' => ['required_if:gunakan_honorarium_khusus,1', 'nullable', Rule::in(['bulanan', 'per_hadir'])],
            'honorarium_pokok' => ['required_if:honorarium_tipe,bulanan', 'nullable', 'numeric', 'min:0'],
            'tarif_per_hadir' => ['required_if:honorarium_tipe,per_hadir', 'nullable', 'numeric', 'min:0'],
            'jenis_kelamin' => ['required_if:role,karyawan', 'nullable', Rule::in(['L', 'P'])],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'tanggal_masuk' => ['required_if:role,karyawan', 'nullable', 'date'],
        ]);

        DB::transaction(function () use ($request, $validated) {
            $user = User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'karyawan_id' => null,
            ]);

            if ($validated['role'] !== 'karyawan') {
                return;
            }

            $karyawan = Karyawan::create([
                'nip' => $validated['nip'],
                'nama' => $validated['nama'],
                'jabatan_id' => $validated['jabatan_id'],
                'honorarium_tipe' => $request->boolean('gunakan_honorarium_khusus') ? $request->honorarium_tipe : null,
                'honorarium_pokok' => $request->boolean('gunakan_honorarium_khusus') && $request->honorarium_tipe === 'bulanan' ? $request->honorarium_pokok : null,
                'tarif_per_hadir' => $request->boolean('gunakan_honorarium_khusus') && $request->honorarium_tipe === 'per_hadir' ? $request->tarif_per_hadir : null,
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'no_hp' => $validated['no_hp'] ?? null,
                'alamat' => $validated['alamat'] ?? null,
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'status' => 'aktif',
            ]);

            $user->update(['karyawan_id' => $karyawan->id]);
        });

        LogAktivitas::catat('tambah_pengguna', "Menambahkan pengguna {$validated['nama']} dengan role {$validated['role']}.");

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit(User $pengguna)
    {
        $pengguna->load('karyawan');
        $bidangs = Bidang::orderBy('nama')->get();
        $jabatans = Jabatan::orderBy('nama')->get();

        return view('admin.pengguna.edit', compact('pengguna', 'bidangs', 'jabatans'));
    }

    public function update(Request $request, User $pengguna)
    {
        if ($pengguna->id === auth()->id() && $request->input('role') !== $pengguna->role) {
            return back()->withInput()->with('error', 'Anda tidak dapat mengubah role akun Anda sendiri.');
        }

        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($pengguna->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role' => ['required', Rule::in(['admin', 'karyawan', 'pimpinan'])],

            'nip' => ['required_if:role,karyawan', 'nullable', 'string', 'max:50', Rule::unique('karyawan', 'nip')->ignore($pengguna->karyawan_id)],
            'jabatan_id' => ['required_if:role,karyawan', 'nullable', 'exists:jabatan,id'],
            'honorarium_tipe' => ['required_if:gunakan_honorarium_khusus,1', 'nullable', Rule::in(['bulanan', 'per_hadir'])],
            'honorarium_pokok' => ['required_if:honorarium_tipe,bulanan', 'nullable', 'numeric', 'min:0'],
            'tarif_per_hadir' => ['required_if:honorarium_tipe,per_hadir', 'nullable', 'numeric', 'min:0'],
            'jenis_kelamin' => ['required_if:role,karyawan', 'nullable', Rule::in(['L', 'P'])],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string'],
            'tanggal_masuk' => ['required_if:role,karyawan', 'nullable', 'date'],
            'status' => ['required_if:role,karyawan', 'nullable', Rule::in(['aktif', 'nonaktif'])],
        ]);

        $newRole = $validated['role'];

        try {
            DB::transaction(function () use ($request, $pengguna, $validated, $oldRole, $newRole) {
                $pengguna->name = $validated['nama'];
                $pengguna->email = $validated['email'];
                $pengguna->role = $newRole;

                if ($request->filled('password')) {
                    $pengguna->password = Hash::make($request->password);
                }

                if ($newRole === 'karyawan') {
                    if ($pengguna->karyawan) {
                        $karyawan = $pengguna->karyawan;
                        $karyawan->update([
                            'nip' => $validated['nip'],
                            'nama' => $validated['nama'],
                            'jabatan_id' => $validated['jabatan_id'],
                            'honorarium_tipe' => $request->boolean('gunakan_honorarium_khusus') ? $request->honorarium_tipe : null,
                            'honorarium_pokok' => $request->boolean('gunakan_honorarium_khusus') && $request->honorarium_tipe === 'bulanan' ? $request->honorarium_pokok : null,
                            'tarif_per_hadir' => $request->boolean('gunakan_honorarium_khusus') && $request->honorarium_tipe === 'per_hadir' ? $request->tarif_per_hadir : null,
                            'jenis_kelamin' => $validated['jenis_kelamin'],
                            'no_hp' => $validated['no_hp'] ?? null,
                            'alamat' => $validated['alamat'] ?? null,
                            'tanggal_masuk' => $validated['tanggal_masuk'],
                            'status' => $validated['status'] ?? 'aktif',
                        ]);
                    } else {
                        $karyawan = Karyawan::create([
                            'nip' => $validated['nip'],
                            'nama' => $validated['nama'],
                            'jabatan_id' => $validated['jabatan_id'],
                            'honorarium_tipe' => $request->boolean('gunakan_honorarium_khusus') ? $request->honorarium_tipe : null,
                            'honorarium_pokok' => $request->boolean('gunakan_honorarium_khusus') && $request->honorarium_tipe === 'bulanan' ? $request->honorarium_pokok : null,
                            'tarif_per_hadir' => $request->boolean('gunakan_honorarium_khusus') && $request->honorarium_tipe === 'per_hadir' ? $request->tarif_per_hadir : null,
                            'jenis_kelamin' => $validated['jenis_kelamin'],
                            'no_hp' => $validated['no_hp'] ?? null,
                            'alamat' => $validated['alamat'] ?? null,
                            'tanggal_masuk' => $validated['tanggal_masuk'],
                            'status' => $validated['status'] ?? 'aktif',
                        ]);

                        $pengguna->karyawan_id = $karyawan->id;
                    }
                } elseif ($pengguna->karyawan_id) {
                    $karyawan = $pengguna->karyawan;

                    if ($karyawan && ($karyawan->presensi()->exists() || $karyawan->izin()->exists() || $karyawan->honorarium()->exists())) {
                        throw new \RuntimeException('Pengguna ini sudah memiliki riwayat presensi/izin/honorarium. Role tidak dapat diubah menjadi non-karyawan karena data tersebut terikat ke data karyawan.');
                    }

                    $pengguna->karyawan_id = null;
                    $karyawan?->delete();
                }

                $pengguna->save();
            });
        } catch (\RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        LogAktivitas::catat('ubah_pengguna', "Mengubah pengguna {$validated['nama']} menjadi role {$newRole}.");

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $pengguna)
    {
        if ($pengguna->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
        }

        $nama = $pengguna->name;

        if ($pengguna->karyawan) {
            if ($pengguna->karyawan->presensi()->exists() || $pengguna->karyawan->izin()->exists() || $pengguna->karyawan->honorarium()->exists()) {
                return back()->with('error', 'Pengguna ini memiliki riwayat presensi/izin/honorarium sehingga tidak dapat dihapus. Nonaktifkan akun/karyawannya saja.');
            }

            $pengguna->karyawan->delete();
        }

        $pengguna->delete();

        LogAktivitas::catat('hapus_pengguna', "Menghapus pengguna {$nama}.");

        return redirect()->route('admin.pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
