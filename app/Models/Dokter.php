<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'user_id',
        'rumah_sakit_id',
        'admin_id',
        'spesialis',
        'noHP'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function draftLaporan()
    {
        return $this->hasMany(DraftLaporan::class);
    }

    public function dataPemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class);
    }

    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class);
    }

    public function jadwalDokter()
    {
        return $this->hasMany(JadwalDokter::class);
    }
}
