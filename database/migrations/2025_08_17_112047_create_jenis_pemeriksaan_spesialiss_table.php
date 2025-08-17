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
        Schema::create('jenis_pemeriksaan_spesialiss', function (Blueprint $table) {
            $table->foreignId('spesialis_id')->constrained('spesialiss')->cascadeOnDelete();
            $table->foreignId('jenis_pemeriksaan_id')->constrained()->cascadeOnDelete();

            $table->primary(['spesialis_id', 'jenis_pemeriksaan_id']); // composite PK

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_pemeriksaan_spesialiss');
    }
};
