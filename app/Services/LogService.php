<?php

namespace App\Services;

use App\Models\Log;
use App\Models\Petugas;

class LogService
{
    /**
     * Create a new class instance.
     */
    public static function create($aktivitas, $petugasId)
    {
        $petugas = Petugas::find($petugasId);

        Log::create([
            'aktivitas' => $aktivitas,
            'jam' => now()->format('H:i:s'),
            'tanggal' => now()->toDateString(),
            'petugas_id' => $petugasId,
            'rumah_sakit_id' => $petugas->rumahSakit->id,
        ]);
    }
}