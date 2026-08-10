<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'nama',
        'role',
        'aktivitas',
        'deskripsi',
        'ip_address',
        'user_agent',
    ];

    // Relasi ke User (bisa null kalau user sudah dihapus)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat satu baris log aktivitas.
     * Sengaja dibungkus try-catch: kalau proses pencatatan log gagal
     * (misal tabel belum di-migrate), proses utama (login, absen, dll)
     * TETAP JALAN seperti biasa, tidak ikut gagal.
     */
    public static function catat(string $aktivitas, ?string $deskripsi = null): void
    {
        try {
            $user = Auth::user();

            static::create([
                'user_id'    => $user?->id,
                'nama'       => $user?->name ?? 'Sistem',
                'role'       => $user?->role,
                'aktivitas'  => $aktivitas,
                'deskripsi'  => $deskripsi,
                'ip_address' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Diamkan; logging tidak boleh menghentikan fitur utama.
        }
    }
}
