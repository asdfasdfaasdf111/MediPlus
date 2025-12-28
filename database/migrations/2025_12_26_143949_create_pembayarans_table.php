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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_pemeriksaan_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('order_id')->nullable();
            $table->string('metodePembayaran');
            $table->string('mediaPembayaran')->nullable();
            $table->string('status');
            $table->integer('harga');
            $table->string('namaJenisPemeriksaan');
            $table->string('namaPasien');
            $table->string('emailPasien');
            $table->string('checkoutLink')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
