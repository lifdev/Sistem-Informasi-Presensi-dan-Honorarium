<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengaturan_gaji', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jabatan_id')
                ->constrained('jabatan')
                ->cascadeOnDelete();

            $table->decimal('gaji_pokok', 15, 2)
                ->default(0);

            $table->decimal('bonus', 15, 2)
                ->default(0)
                ->comment('Bonus bulanan');

            $table->decimal('potongan_alpha', 15, 2)
                ->default(0)
                ->comment('Potongan per hari alpha');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturan_gaji');
    }
};
