<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalitas extends Model
{
    protected $table = 'modalitass';
    protected $fillable = [
        'rumah_sakit_id',
        'kelompok_jenis_pemeriksaan_id',
        'namaModalitas',
        'kodeRuang',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function kelompokJenisPemeriksaan()
    {
        return $this->belongsTo(KelompokJenisPemeriksaan::class);
    }
}
