<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('karyawan_id')->constrained('karyawan')->cascadeOnDelete();
            $table->date('tanggal');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_pulang')->nullable();
            $table->decimal('lat_masuk', 10, 7)->nullable();
            $table->decimal('lng_masuk', 10, 7)->nullable();
            $table->decimal('lat_pulang', 10, 7)->nullable();
            $table->decimal('lng_pulang', 10, 7)->nullable();
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpha'])->default('hadir');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->unique(['karyawan_id', 'tanggal']); // 1 record per hari per karyawan
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('presensi');
    }
};
