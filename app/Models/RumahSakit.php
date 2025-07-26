<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RumahSakit extends Model
{
    protected $fillable = [
        'super_admin_id',
        'nama',
        'alamat',
        'noTelepon',
        'jamBuka',
        'jamTutup',
        'jumlahPasien'
    ];

    public function superadmin()
    {
        return $this->belongsTo(SuperAdmin::class);
    }

    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }

    public function log()
    {
        return $this->hasMany(Log::class)
                    ->orderBy('tanggal', 'desc')
                    ->orderBy('jam', 'desc');
    }

    public function pasien()
    {
        return $this->hasMany(Pasien::class);
    }

    public function modalitas()
    {
        return $this->hasMany(Modalitas::class);
    }

    public function datapemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class);
    }

    public function petugas()
    {
        return $this->hasMany(Petugas::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function jumlahDokter(){
        return $this->dokter()->count();
    }

    public function jumlahPetugas(){
        return $this->petugas()->count();
    }

    public function logTerbaru(){
        return $this->log()
                ->limit(10);
    }

    public function updateJadwal($jamBuka, $jamTutup){
        $this->jamBuka = $jamBuka;
        $this->jamTutup = $jamTutup;
        $this->save();
    }

    public function updateJumlahPasien($jumlahPasien){
        $this->jumlahPasien = $jumlahPasien;
        $this->save();
    }
}
