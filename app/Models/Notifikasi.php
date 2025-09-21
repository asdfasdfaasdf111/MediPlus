<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = [
        'data_pemeriksaan_id',
        'deskripsi'
    ];

    public function dataPemeriksaan()
    {
        return $this->belongsTo(DataPemeriksaan::class);
    }
}
