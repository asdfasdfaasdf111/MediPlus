<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterAntrian extends Model
{
    protected $fillable = [
        'jenis_pemeriksaan_id',
        'tanggalAntrian',
        'nomorTerakhir',
    ];

    public function jenisPemeriksaan()
    {
        return $this->belongsTo(JenisPemeriksaan::class);
    }
}
