<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRujukan extends Model
{
    protected $fillable = [
        'data_pasien_id',
        'namaFaskes',
        'namaDokterPerujuk',
        'diagnosaKerja',
        'alasanRujukan',
        'tanggalPemeriksaanFaskes',
        'permintaanPemeriksaan',
        'formulirRujukan',
        'namaFile'
    ];

    public function dataPasien()
    {
        return $this->belongsTo(DataPasien::class);
    }

    public function dataPemeriksaan()
    {
        return $this->hasOne(DataPemeriksaan::class);
    }
}