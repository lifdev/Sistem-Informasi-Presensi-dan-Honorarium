<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengajuan_presensi', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')
                ->constrained('karyawan')
                ->cascadeOnDelete();

            $table->date('tanggal');
            $table->time('jam_masuk');
            $table->text('alasan');
            $table->string('lampiran')->nullable()->comment('Path bukti pendukung (opsional)');

            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');

            $table->foreignId('disetujui_oleh')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('disetujui_at')->nullable();

            $table->timestamps();

            // Satu karyawan hanya boleh punya satu pengajuan aktif per tanggal
            $table->unique(['karyawan_id', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_presensi');
    }
};
