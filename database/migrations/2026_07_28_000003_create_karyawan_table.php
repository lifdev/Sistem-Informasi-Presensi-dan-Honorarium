<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create("karyawan", function (Blueprint $table) {
            $table->id();
            $table->string("nip")->unique()->comment("Nomor Induk Pegawai");
            $table->string("nama");

            $table
                ->foreignId("jabatan_id")
                ->nullable()
                ->constrained("jabatan")
                ->cascadeOnDelete();

            $table->enum("jenis_kelamin", ["L", "P"]);
            $table->string("no_hp")->nullable();
            $table->string("alamat")->nullable();
            $table->date("tanggal_masuk");
            $table->enum("status", ["aktif", "nonaktif"])->default("aktif");
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists("karyawan");
    }
};
