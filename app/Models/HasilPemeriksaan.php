<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPemeriksaan extends Model
{
        protected $fillable = [
        'data_pemeriksaan_id',
        'dokter_id',
        'pasien_id',
        'hasilPemeriksaan',
        'fileLampiran',
        'mitraRadiologi'
    ];
}
