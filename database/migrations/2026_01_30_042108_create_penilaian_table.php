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
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_penilai');
            $table->unsignedBigInteger('id_ternilai');
            $table->decimal('ber', 8, 2)->nullable();
            $table->decimal('a1', 8, 2)->nullable();
            $table->decimal('k1', 8, 2)->nullable();
            $table->decimal('h', 8, 2)->nullable();
            $table->decimal('l', 8, 2)->nullable();
            $table->decimal('a2', 8, 2)->nullable();
            $table->decimal('k2', 8, 2)->nullable();
            // No timestamps as per model
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};
