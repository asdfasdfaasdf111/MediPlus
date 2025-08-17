<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $fillable = [
        'dokter_id',
        'indexJadwal',
        'jamMulai',
        'jamSelesai'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
