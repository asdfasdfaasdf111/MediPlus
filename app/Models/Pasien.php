<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = [
        'rumahsakit_id',
        'master_pasien_id',
        'alamatDomisili',
        'tanggalLahir',
        'noIdentitas',
        'jenisIdentitas',
        'jenisKelamin',
        'noHP',
        'alergi',
        'golonganDarah',
        'nomorRekamMedis'
    ];

    public function rumahsakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function masterpasien()
    {
        return $this->belongsTo(MasterPasien::class);
    }

    public function hasilpemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class);
    }

    public function datarujukan()
    {
        return $this->hasMany(DataRujukan::class);
    }
}
