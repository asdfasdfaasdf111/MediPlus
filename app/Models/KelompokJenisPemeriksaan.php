<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KelompokJenisPemeriksaan extends Model
{
    protected $fillable = [
        'namaKelompok',
    ];

    public function modalitas()
    {
        return $this->hasMany(Modalitas::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->hasMany(JenisPemeriksaan::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }
}
