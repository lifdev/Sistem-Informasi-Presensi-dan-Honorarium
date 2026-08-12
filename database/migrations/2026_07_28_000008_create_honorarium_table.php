<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('honorarium', function (Blueprint $table) {
            $table->id();

            $table->foreignId('karyawan_id')
                ->constrained('karyawan')
                ->cascadeOnDelete();

            $table->integer('bulan');
            $table->integer('tahun');

            $table->integer('total_hadir')->default(0);
            $table->integer('total_izin')->default(0);
            $table->integer('total_sakit')->default(0);
            $table->integer('total_alpha')->default(0);

            $table->decimal('honorarium_pokok', 15, 2)->default(0);
            $table->decimal('bonus', 15, 2)->default(0);

            $table->decimal('total_potongan', 15, 2)->default(0);
            $table->decimal('honorarium_bersih', 15, 2)->default(0);

            $table->enum('status', ['draft', 'final'])->default('draft');

            $table->timestamps();

            $table->unique(['karyawan_id', 'bulan', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('honorarium');
    }
};
