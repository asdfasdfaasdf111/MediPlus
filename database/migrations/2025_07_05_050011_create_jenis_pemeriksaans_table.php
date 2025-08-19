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
        Schema::create('jenis_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modalitas_id')->constrained('modalitass')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('rumah_sakit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('namaJenisPemeriksaan');
            $table->string('namaPemeriksaanSpesifik')->nullable();
            $table->string('kelompokJenisPemeriksaan');
            $table->boolean('pemakaianKontras');
            $table->time('lamaPemeriksaan');
            $table->boolean('diDampingiDokter');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pemeriksaans');
    }
};
