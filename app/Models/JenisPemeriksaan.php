<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPemeriksaan extends Model
{
    protected $fillable = [
        'modalitas_id',
        'rumah_sakit_id',
        'namaJenisPemeriksaan',
        'namaPemeriksaanSpesifik',
        'kelompokJenisPemeriksaan',
        'pemakaianKontras',
        'lamaPemeriksaan',
        'diDampingiDokter'
    ];

    public function modalitas()
    {
        return $this->belongsTo(Modalitas::class);
    }

    public function dataPemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }
}
