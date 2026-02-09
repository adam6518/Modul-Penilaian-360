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
        Schema::create('periode_pegawai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_periode');
            $table->unsignedBigInteger('id_pegawai');
            $table->string('nama_pegawai');
            $table->unsignedBigInteger('id_atasan')->nullable();
            $table->tinyInteger('status')->default(1);
            // No timestamps as per model
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periode_pegawai');
    }
};
