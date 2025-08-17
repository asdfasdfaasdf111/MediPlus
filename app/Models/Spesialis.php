<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spesialis extends Model
{
    protected $table = 'spesialiss';
    protected $fillable = [
        'rumah_sakit_id',
        'namaSpesialis'
    ];

    public function jenisPemeriksaan()
    {
        return $this->belongsToMany(JenisPemeriksaan::class, 'jenis_pemeriksaan_spesialis');
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }
}
