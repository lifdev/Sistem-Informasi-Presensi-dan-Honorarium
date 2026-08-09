<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaturan_jam', function (Blueprint $table) {
            $table->id();

            $table->time('jam_masuk_mulai')
                ->default('07:00:00');

            $table->time('jam_masuk_selesai')
                ->default('09:00:00')
                ->comment('Batas akhir absen masuk');

            $table->boolean('aktif')
                ->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_jam');
    }
};
