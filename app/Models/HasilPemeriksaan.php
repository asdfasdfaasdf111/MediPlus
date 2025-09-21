<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilPemeriksaan extends Model
{
    protected $fillable = [
        'data_pemeriksaan_id',
        'dokter_id',
        'data_pasien_id',
        'hasilPemeriksaan',
        'fileLampiran',
        'mitraRadiologi'
    ];

    public function dataPemeriksaan()
    {
        return $this->belongsTo(DataPemeriksaan::class);
    }

    public function dataPasien()
    {
        return $this->belongsTo(DataPasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
