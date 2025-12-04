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
        //KEMUNGKINAN GA KEPAKE, KALO ENGGA NANTI HAPUS AJA
        // Schema::create('jenis_pemeriksaan_spesifiks', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('jenis_pemeriksaan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
        //     $table->string('namaPemeriksaanSpesifik');
        //     $table->boolean('pemakaianKontras');
        //     $table->integer('lamaPemeriksaan');
        //     $table->boolean('diDampingiDokter');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pemeriksaan_spesifiks');
    }
};
