<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            // Jika NULL, karyawan mewarisi pengaturan honorarium dari jabatannya.
            // Jika diisi, nilai ini menjadi override khusus untuk karyawan tersebut.
            $table->enum('honorarium_tipe', ['bulanan', 'per_hadir'])
                ->nullable()
                ->after('jabatan_id');

            $table->decimal('honorarium_pokok', 15, 2)
                ->nullable()
                ->after('honorarium_tipe');

            $table->decimal('tarif_per_hadir', 15, 2)
                ->nullable()
                ->after('honorarium_pokok');
        });
    }

    public function down(): void
    {
        Schema::table('karyawan', function (Blueprint $table) {
            $table->dropColumn([
                'honorarium_tipe',
                'honorarium_pokok',
                'tarif_per_hadir',
            ]);
        });
    }
};
