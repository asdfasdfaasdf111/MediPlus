<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPemeriksaan extends Model
{
    protected $fillable = [
        'petugas_id',
        'dokter_id',
        'jenis_pemeriksaan_id',
        'pasien_id',
        'rumah_sakit_id',
        'data_rujukan_id',
        'tanggalPemeriksaan',
        'rentangWaktuKedatangan',
        'namaPendamping',
        'nomorPendamping',
        'historyJenisPemeriksaan',
        'historyTanggalPemeriksaan',
        'historyJamPemeriksaan',
        'catatanPetugas',
        'statusUtama',
        'statusDokter',
        'statusPetugas',
        'statusPasien'
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->belongsTo(JenisPemeriksaan::class);
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function dataRujukan()
    {
        return $this->belongsTo(DataRujukan::class);
    }

    public function hasilPemeriksaan()
    {
        return $this->hasOne(HasilPemeriksaan::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }
}
