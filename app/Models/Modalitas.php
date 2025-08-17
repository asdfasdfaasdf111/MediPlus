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

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->hasMany(JenisPemeriksaan::class);
    }

    public function dicom()
    {
        return $this->hasMany(Dicom::class);
    }
}
