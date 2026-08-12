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
        Schema::table('pengaturan_honorarium', function (Blueprint $table) {
            $table->unique('jabatan_id');
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::table('pengaturan_honorarium', function (Blueprint $table) {
            $table->dropUnique(['jabatan_id']);
        });
    }
};
