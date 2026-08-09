<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('kalender_kerja', function (Blueprint $table) {
            $table->id();

            // Satu tanggal hanya boleh ada satu data
            $table->date('tanggal')->unique();

            // Apakah tanggal ini dihitung sebagai hari kerja
            $table->boolean('is_hari_kerja')->default(false);

            // Opsional, misal: HUT RI, Cuti Bersama, Libur Yayasan
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('kalender_kerja');
    }
};
