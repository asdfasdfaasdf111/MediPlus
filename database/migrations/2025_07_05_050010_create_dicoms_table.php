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
        Schema::create('dicoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modalitas_id')->constrained('modalitass')->onUpdate('cascade')->onDelete('cascade');
            $table->string('alamatIP');
            $table->string('netMask');
            $table->string('layananDicom');
            $table->string('peran');
            $table->string('AET');
            $table->string('port');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dicoms');
    }
};
