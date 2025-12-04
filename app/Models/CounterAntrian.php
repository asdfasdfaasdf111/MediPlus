<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounterAntrian extends Model
{
    protected $fillable = [
        'rumah_sakit_id',
        'namaJenisPemeriksaan',
        'tanggalAntrian',
        'nomorTerakhir',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(rumahSakit::class);
    }
}
