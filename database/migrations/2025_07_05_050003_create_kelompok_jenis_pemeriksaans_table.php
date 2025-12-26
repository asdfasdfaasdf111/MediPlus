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
        Schema::create('kelompok_jenis_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_sakit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('namaKelompok');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompok_jenis_pemeriksaan');
    }
};