<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Bonus dipindahkan dari "pengaturan_gaji" (per jabatan) ke
     * "honorarium" (per karyawan, per bulan). Alasan: bonus bersifat
     * tidak rutin dan tergantung penilaian individu tiap bulan,
     * sehingga tidak tepat kalau disamaratakan per jabatan.
     *
     * Kolom "bonus" di tabel honorarium sudah ada sejak awal dan
     * dipakai sebagai satu-satunya sumber nilai bonus mulai sekarang.
     */
    public function up(): void
    {
        Schema::table('pengaturan_gaji', function (Blueprint $table) {
            $table->dropColumn('bonus');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_gaji', function (Blueprint $table) {
            $table->decimal('bonus', 15, 2)
                ->default(0)
                ->comment('Bonus bulanan (deprecated, dipindahkan ke tabel honorarium)')
                ->after('gaji_pokok');
        });
    }
};
