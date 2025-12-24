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
        Schema::create('counter_antrians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rumah_sakit_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('kelompok_jenis_pemeriksaan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggalAntrian');
            $table->unsignedInteger('nomorTerakhir');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counter_antrian');
    }
};
