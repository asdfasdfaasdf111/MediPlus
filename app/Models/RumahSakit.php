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
        'jumlahPasien'
    ];

    public function superAdmin()
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

    public function dataPemeriksaan()
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

    public function spesialis()
    {
        return $this->hasMany(Spesialis::class);
    }

    public function jadwalRumahSakit()
    {
        return $this->hasMany(JadwalRumahSakit::class)
                    ->orderBy('indexJadwal', 'asc');
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

    public function updateJadwal($jadwalArray){
        $jadwalRS = $this->jadwalRumahSakit;
        for ($i = 0; $i < 7; $i++){
            $jadwalRS[$i]->jamBuka = $jadwalArray[$i + 1]['jamBuka'];
            $jadwalRS[$i]->jamTutup = $jadwalArray[$i + 1]['jamTutup'];
            $jadwalRS[$i]->buka = $jadwalArray[$i + 1]['buka'];
            $jadwalRS[$i]->save();
        }
    }

    public function updateJumlahPasien($jumlahPasien){
        $this->jumlahPasien = $jumlahPasien;
        $this->save();
    }

}
