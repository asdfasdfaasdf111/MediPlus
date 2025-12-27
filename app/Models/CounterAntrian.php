<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterAntrian extends Model
{
    protected $fillable = [
        'rumah_sakit_id',
        'kelompok_jenis_pemeriksaan_id',
        'tanggalAntrian',
        'nomorTerakhir',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(rumahSakit::class);
    }
}