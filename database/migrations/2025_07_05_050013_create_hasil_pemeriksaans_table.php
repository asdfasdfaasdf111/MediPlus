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
        Schema::create('hasil_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_pemeriksaan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('data_pasien_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('hasilPemeriksaan');
            $table->string('fileLampiran');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_pemeriksaans');
    }
};
