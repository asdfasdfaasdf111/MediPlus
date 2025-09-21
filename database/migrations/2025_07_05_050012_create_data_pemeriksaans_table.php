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
        Schema::create('data_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('petugass')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('jenis_pemeriksaan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('data_pasien_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('rumah_sakit_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('data_rujukan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->date('tanggalPemeriksaan');
            $table->time('rentangWaktuKedatangan');
            $table->string('namaPendamping')->nullable();
            $table->string('nomorPendamping')->nullable();
            $table->string('historyJenisPemeriksaan')->nullable();
            $table->date('historyTanggalPemeriksaan')->nullable();
            $table->time('historyJamPemeriksaan')->nullable();
            $table->string('catatanPetugas')->nullable();
            $table->string('statusUtama');
            $table->string('statusDokter');
            $table->string('statusPetugas');
            $table->string('statusPasien');
            $table->string('riwayatAlamatDomisili');
            $table->date('riwayatTanggalLahir');
            $table->string('riwayatJenisKelamin');
            $table->string('riwayatNoHP');
            $table->string('riwayatAlergi');
            $table->string('riwayatGolonganDarah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pemeriksaans');
    }
};
