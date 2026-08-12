<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pengaturan_honorarium', function (Blueprint $table) {
            // 'bulanan'   = honorarium flat per bulan (karyawan tetap), potongan_alpha berlaku.
            // 'per_hadir' = honorarium dihitung dari tarif x jumlah hari hadir
            //               (relawan guru / ustad part-time). Tidak ada potongan alpha
            //               karena hari tidak hadir otomatis tidak dibayar.
            $table->enum('tipe', ['bulanan', 'per_hadir'])
                ->default('bulanan')
                ->after('jabatan_id');

            $table->decimal('tarif_per_hadir', 15, 2)
                ->default(0)
                ->after('potongan_alpha')
                ->comment('Tarif per hari hadir, dipakai jika tipe = per_hadir');
        });
    }

    public function down(): void
    {
        Schema::table('pengaturan_honorarium', function (Blueprint $table) {
            $table->dropColumn(['tipe', 'tarif_per_hadir']);
        });
    }
};
