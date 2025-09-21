<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPasien extends Model
{
    protected $fillable = [
        'master_pasien_id',
        'alamatDomisili',
        'tanggalLahir',
        'noIdentitas',
        'jenisIdentitas',
        'jenisKelamin',
        'noHP',
        'alergi',
        'golonganDarah',
    ];

    public function masterPasien()
    {
        return $this->belongsTo(MasterPasien::class);
    }

    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class);
    }

    public function dataRujukan()
    {
        return $this->hasMany(DataRujukan::class);
    }
}
