<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class DataPasien extends Model
{
    protected $fillable = [
        'master_pasien_id',
        'namaLengkap',
        'alamatDomisili',
        'tanggalLahir',
        'noIdentitas',
        'jenisIdentitas',
        'jenisKelamin',
        'noHP',
        'alergi',
        'golonganDarah',
        'hubunganKeluarga',
    ];
    protected function namaLengkap(): Attribute
    {
        return Attribute::make(
            // saat ambil dari DB → pastikan uppercase juga
            get: fn ($value) => $value ? mb_strtoupper($value, 'UTF-8') : $value,
            // saat simpan → paksa uppercase
            set: fn ($value) => $value ? mb_strtoupper(trim($value), 'UTF-8') : $value,
        );
    }

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
