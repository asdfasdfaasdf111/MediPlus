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
        Schema::create('data_rujukans', function (Blueprint $table) {
            $table->id();
            $table->string('namaFaskes');
            $table->string('namaDokterPerujuk');
            $table->string('diagnosaKerja');
            $table->string('alasanRujukan');
            $table->date('tanggalPemeriksaanFaskes');
            $table->string('permintaanPemeriksaan');
            $table->string('formulirRujukan');
            $table->foreignId('data_pasien_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('namaFile');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_rujukans');
    }
};
