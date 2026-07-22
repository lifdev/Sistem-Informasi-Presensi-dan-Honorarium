<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaturan_gaji', function (Blueprint $table) {
            $table->id();
            $table->string('jabatan')->unique();
            $table->decimal('gaji_pokok', 15, 2)->default(0);
            $table->decimal('tunjangan_hadir', 15, 2)->default(0)->comment('Per hari hadir');
            $table->decimal('potongan_alpha', 15, 2)->default(0)->comment('Per hari alpha');
            $table->decimal('potongan_izin', 15, 2)->default(0)->comment('Per hari izin');
            $table->decimal('potongan_sakit', 15, 2)->default(0)->comment('Per hari sakit');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_gaji');
    }
};
