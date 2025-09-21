<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalitas extends Model
{
    protected $table = 'modalitass';
    protected $fillable = [
        'rumah_sakit_id',
        'namaModalitas',
        'jenisModalitas',
        'kodeRuang',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->hasMany(JenisPemeriksaan::class);
    }
}
