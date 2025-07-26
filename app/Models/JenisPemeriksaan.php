<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPemeriksaan extends Model
{
    protected $fillable = [
        'modalitas_id',
        'namaJenisPemeriksaan',
        'namaPemeriksaanSpesifik',
        'kelompokJenisPemeriksaan',
        'pemakaianKontras',
        'lamaPemeriksaan'
    ];

    public function modalitas()
    {
        return $this->belongsTo(Modalitas::class);
    }

    public function datapemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class);
    }
}
