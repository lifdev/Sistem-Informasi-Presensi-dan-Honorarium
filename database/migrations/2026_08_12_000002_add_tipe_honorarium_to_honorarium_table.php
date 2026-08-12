<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('honorarium', function (Blueprint $table) {
            // Disimpan sebagai snapshot per baris, bukan diambil ulang dari
            // pengaturan_honorarium, supaya riwayat bulan lalu tidak berubah
            // kalau tipe honorarium jabatan diubah admin di kemudian hari.
            $table->enum('tipe_honorarium', ['bulanan', 'per_hadir'])
                ->default('bulanan')
                ->after('karyawan_id');

            $table->decimal('tarif_per_hadir', 15, 2)
                ->nullable()
                ->after('honorarium_pokok');
        });
    }

    public function down(): void
    {
        Schema::table('honorarium', function (Blueprint $table) {
            $table->dropColumn(['tipe_honorarium', 'tarif_per_hadir']);
        });
    }
};
