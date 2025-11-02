<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class RumahSakit extends Model
{
    protected $fillable = [
        'super_admin_id',
        'nama',
        'alamat',
        'noTelepon',
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

    public function modalitas()
    {
        return $this->hasMany(Modalitas::class);
    }

    public function dataPemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class)
        ->where('statusUtama', '!=', 'Draft')
        ->ordered();
    }

    public function petugas()
    {
        return $this->hasMany(Petugas::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->hasMany(JenisPemeriksaan::class)
                    ->orderBy('namaJenisPemeriksaan', 'asc')
                    ->orderBy('namaPemeriksaanSpesifik', 'asc');
    }

    public function jenisPemeriksaanSpesifik($namaJenisPemeriksaan)
    {
        return $this->hasMany(JenisPemeriksaan::class)
                    ->where('namaJenisPemeriksaan', $namaJenisPemeriksaan)
                    ->orderBy('namaPemeriksaanSpesifik', 'asc');
    }

    public function namaJenisPemeriksaan()
    {
        return $this->jenisPemeriksaan()->pluck('namaJenisPemeriksaan')->unique()->values()->toArray();;
    }

    // yg dataPemeriksaan itu buat kalo petugas update jadwal, 
    // jadinya kalo jam dan tanggalnya == jam dan tanggal original, pasti bisa dipilih
    // sama jenis pemeriksaannya juga harus menggunakan modalitas yg sama
    public function jamTersedia($jenisPemeriksaan, $tanggalPemeriksaan, $dataPemeriksaan = null)
    {
        $listJam = [];
        // kalo tanggal yang dipilih <= hari ini, brarti uda gabisa daftar lagi
        if (Carbon::parse($tanggalPemeriksaan)->lte(Carbon::today())) {
            return $listJam;
        } 
        $hariIni = Carbon::parse($tanggalPemeriksaan)->isoWeekday();
        $hariIni = $this->jadwalRumahSakit()
                        ->where('indexJadwal', $hariIni)
                        ->first();
        $jamBuka = Carbon::parse($hariIni->jamBuka);
        $jamBuka = $jamBuka->ceilHour();

        $jamTutup = Carbon::parse($hariIni->jamTutup);
        $jamTutup = $jamTutup->floorUnit('hour');

        $dataHariIni = $this->dataPemeriksaan()
                                ->where('tanggalPemeriksaan', $tanggalPemeriksaan)
                                ->whereHas('jenisPemeriksaan', function ($q) use ($jenisPemeriksaan) {
                                    $q->where('modalitas_id', $jenisPemeriksaan->modalitas_id);
                                })->get();
        while($jamBuka < $jamTutup){
            if ($dataPemeriksaan != null && $tanggalPemeriksaan == $dataPemeriksaan->tanggalPemeriksaan && $jamBuka == $dataPemeriksaan->rentangWaktuKedatangan && $dataPemeriksaan->jenisPemeriksaan->modalitasId == $jenisPemeriksaan->modalitasId){
                $listJam[] = $jamBuka->format('H:i');
                $jamBuka->addHour();
                continue;
            }
            $totalTime = 0;
            $dataJamIni = $dataHariIni->where('rentangWaktuKedatangan', $jamBuka->format('H:i:s'));
            foreach($dataJamIni as $data){
                $jenisSekarang = $data->jenisPemeriksaan;
                $totalTime += $jenisSekarang->lamaPemeriksaan;
            }
            if ($totalTime + $jenisPemeriksaan->lamaPemeriksaan <= 60){
                $listJam[] = $jamBuka->format('H:i');
            }
            $jamBuka->addHour();
        }

        return $listJam;
    }

    //bisa dibikin lebih efisien tpi ribet
    //buat dapetin hari apa aja yang jadwalnya uda penuh
    public function jadwalPenuh($jenisPemeriksaan)
    {
        $unavailable = [];
        $data = $this->dataPemeriksaan()
                    ->whereHas('jenisPemeriksaan', function ($q) use ($jenisPemeriksaan) {
                        $q->where('modalitas_id', $jenisPemeriksaan->modalitas_id);
                    })
                    ->orderBy('tanggalPemeriksaan', 'asc')
                    ->get();
        $prev = null;
        foreach ($data as $dataPemeriksaan) {
            //klo tanggalny ud dicek, skip aj
            if ($prev !== null && $prev->tanggalPemeriksaan == $dataPemeriksaan->tanggalPemeriksaan) {
                continue;
            }
            $listJam = $this->jamTersedia($jenisPemeriksaan, $dataPemeriksaan->tanggalPemeriksaan);
            // if (empty($listJam)){
            //     $unavailable[] = $dataPemeriksaan->tanggalPemeriksaan;
            // }
            // $prev = $dataPemeriksaan;
        }
        return $unavailable;
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

    public function scopeAktif($q)
    {
        return Schema::hasColumn('rumah_sakits', 'aktif') ? $q->where('aktif', 1) : $q;
    }


}
