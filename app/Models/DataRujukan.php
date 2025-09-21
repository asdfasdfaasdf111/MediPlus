<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRujukan extends Model
{
    protected $fillable = [
        'pasien_id',
        'namaFaskes',
        'namaDokterPerujuk',
        'diagnosaKerja',
        'alasanRujukan',
        'tanggalPemeriksaanFaskes',
        'permintaanPemeriksaan',
        'formulirRujukan'
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dataPemeriksaan()
    {
        return $this->hasOne(DataPemeriksaan::class);
    }
}
