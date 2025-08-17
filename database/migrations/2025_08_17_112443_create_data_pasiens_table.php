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
        Schema::create('data_pasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_pasien_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('alamatDomisili');
            $table->date('tanggalLahir');
            $table->string('noIdentitas');
            $table->string('jenisIdentitas');
            $table->string('jenisKelamin');
            $table->string('noHP');
            $table->string('alergi');
            $table->string('golonganDarah');
            $table->boolean('dataPemilikAkun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pasiens');
    }
};
