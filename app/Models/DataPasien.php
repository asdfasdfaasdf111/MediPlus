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
        'dataPemilikAkun'
    ];

    public function masterPasien()
    {
        return $this->belongsTo(MasterPasien::class);
    }
}
