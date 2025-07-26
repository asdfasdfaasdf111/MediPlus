<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modalitas extends Model
{
    protected $fillable = [
        'rumah_sakit_id',
        'namaModalitas',
        'jenisModalitas',
        'merekModalitas',
        'tipeModalitas',
        'nomorSeriModalitas',
        'kodeRuang',
        'alamatIP'
    ];

    public function rumahsakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function jenispemeriksaan()
    {
        return $this->hasMany(JenisPemeriksaan::class);
    }

    public function dicom()
    {
        return $this->hasMany(Dicom::class);
    }
}
