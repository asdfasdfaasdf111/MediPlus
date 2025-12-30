<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class RumahSakit extends Model
{
    protected $fillable = [
        'super_admin_id',
        'nama',
        'alamat',
        'noTelepon',
        'foto',
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
                    ->orderBy('namaJenisPemeriksaan', 'asc');
    }

    // public function jenisPemeriksaanSpesifik($namaJenisPemeriksaan)
    // {
    //     return $this->hasMany(JenisPemeriksaan::class)
    //                 ->where('namaJenisPemeriksaan', $namaJenisPemeriksaan)
    //                 ->orderBy('namaPemeriksaanSpesifik', 'asc');
    // }

    // public function namaJenisPemeriksaan()
    // {
    //     return $this->jenisPemeriksaan()->pluck('namaJenisPemeriksaan')->unique()->values()->toArray();;
    // }

    public function kelompokJenisPemeriksaan()
    {
        return $this->hasMany(KelompokJenisPemeriksaan::class);
    }

    public function namaKelompokJenisPemeriksaan()
    {
        return $this->kelompokJenisPemeriksaan()
            ->select('id', 'namaKelompok')
            ->orderBy('namaKelompok')
            ->get();
    }

    public function namaJenisPemeriksaan($kelompokJenisPemeriksaanId)
    {
        return $this->jenisPemeriksaan()
                ->where('kelompok_jenis_pemeriksaan_id', $kelompokJenisPemeriksaanId)
                ->select('id', 'namaJenisPemeriksaan')
                ->orderBy('namaJenisPemeriksaan', 'asc')
                ->get();
    }

    // yg dataPemeriksaan itu buat kalo petugas update jadwal, 
    // jadinya kalo jam dan tanggalnya == jam dan tanggal original, pasti bisa dipilih
    // sama jenis pemeriksaannya juga harus menggunakan modalitas yg sama
    public function jamTersedia($jenisPemeriksaan, $tanggalPemeriksaan, $dataPemeriksaan = null)
    {
        $listJam = [];
        $jump = $jenisPemeriksaan->getJump();

        $slots = [
            'jump' => $jump,
            'listJam' => $listJam,
        ];
        
        // kalo tanggal yang dipilih < hari ini, brarti uda gabisa daftar lagi
        if (Carbon::parse($tanggalPemeriksaan)->lt(Carbon::today())) {
            return $slots;
        } 
        
        $hariIni = Carbon::parse($tanggalPemeriksaan)->isoWeekday();
        $hariIni = $this->jadwalRumahSakit()
                        ->where('indexJadwal', $hariIni)
                        ->first();
        if (!$hariIni->buka) {
            $slots['listJam'] = $listJam;
            return $slots;
        }
        $jamBuka = Carbon::parse($hariIni->jamBuka);
        $jamBuka = $jamBuka->ceilHour();
        $start = $jamBuka->hour;

        $jamTutup = Carbon::parse($hariIni->jamTutup);
        $end = 0;
        if ($jamTutup->hour === 0 && $jamTutup->minute === 0) {
            $end = 24;
        }
        else{
            $jamTutup = $jamTutup->floorUnit('hour');
            $end = $jamTutup->hour;
        }

        $kelompokJenisPemeriksaan = $jenisPemeriksaan->kelompokJenisPemeriksaan;
        $jumlahAlat = $kelompokJenisPemeriksaan->modalitas->count();
        $dataHariIni = $this->dataPemeriksaan()
                                ->where('tanggalPemeriksaan', $tanggalPemeriksaan)
                                ->whereHas('jenisPemeriksaan', function ($q) use ($jenisPemeriksaan) {
                                    $q->where('kelompok_jenis_pemeriksaan_id', $jenisPemeriksaan->kelompok_jenis_pemeriksaan_id);
                                })->get();
        //untuk setiap jam, nyimpen uda berapa menit yg kepake
        $penggunaanKuota = array_fill(0, 24, 0);

        foreach ($dataHariIni as $data) {
            $index = Carbon::parse($data->rentangWaktuKedatangan)->hour;
            $dur = $data->jenisPemeriksaan->lamaPemeriksaan;
            while($dur > 0){
                $penggunaanKuota[$index] += min($dur, 60);
                $dur -= 60;
                $index++;
            }
        }


        while($start < $end){
            //kalo sisa waktunya udah ga cukup, brarti ga usah tunjukin jamnya
            if ($start + $jump > $end){
                break;
            }
            $tanggal = Carbon::parse($tanggalPemeriksaan);

            $waktuPemeriksaan = $tanggal
                ->copy()
                ->setTimeFrom($jamBuka);
            $now = Carbon::now();

            $diffInHours = $now->diffInHours($waktuPemeriksaan, false);
            // kalo <= 12 jam dari sekarang, uda ga bisa daftar di jam ini
            if ($diffInHours <= 12) {
                $jamBuka->addHour($jump);
                $start += $jump;
                continue;
            }
            //kalo jamnya itu sama dengan yang diedit sekarang, uda fix bisa(jadi kaya ga ganti jam gitu)
            if ($dataPemeriksaan != null && $tanggalPemeriksaan == $dataPemeriksaan->tanggalPemeriksaan && $jamBuka->format('H:i') == Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->format('H:i') && $dataPemeriksaan->jenisPemeriksaan->modalitasId == $jenisPemeriksaan->modalitasId){
                $listJam[] = $jamBuka->format('H:i');
                $jamBuka->addHour($jump);
                $start += $jump;
                continue;
            }
            
            $index = Carbon::parse($jamBuka)->hour;
            $totalJam = 0;
            for ($i = $index; $i < min($index + $jump, 24); $i++){
                $totalJam += $penggunaanKuota[$i];
            }
            if ($totalJam + $jenisPemeriksaan->lamaPemeriksaan <= 60 * $jump * $jumlahAlat){
                $listJam[] = $jamBuka->format('H:i');
            }
            $jamBuka->addHour($jump);
            $start += $jump;
        }

        $slots = [
            'jump' => $jump,
            'listJam' => $listJam,
        ];

        return $slots;
    }

    //ambil semua jam yang mungkin selama >= waktu sekarang
    public function jamTersediaPetugas($jenisPemeriksaan, $tanggalPemeriksaan)
    {
        $jump = $jenisPemeriksaan->getJump();
        $listJam = [];
        $slots = [
            'jump' => $jump,
            'listJam' => $listJam,
        ];
        // kalo tanggal yang dipilih < hari ini, brarti uda gabisa daftar lagi
        if (Carbon::parse($tanggalPemeriksaan)->lt(Carbon::today())) {
            return $slots;
        }
        
        $hariIni = Carbon::parse($tanggalPemeriksaan)->isoWeekday();
        $hariIni = $this->jadwalRumahSakit()
                    ->where('indexJadwal', $hariIni)
                    ->first();
        if (!$hariIni->buka) {
            $slots['listJam'] = $listJam;
            return $slots;
        }
        $jamBuka = Carbon::parse($hariIni->jamBuka);
        $jamBuka = $jamBuka->ceilHour();
        $start = $jamBuka->hour;
        
        $jamTutup = Carbon::parse($hariIni->jamTutup);
        $end = 0;
        if ($jamTutup->hour === 0 && $jamTutup->minute === 0) {
            $end = 24;
        }
        else{
            $jamTutup = $jamTutup->floorUnit('hour');
            $end = $jamTutup->hour;
        }
        
        
        while($start < $end){
            
            if ($start + $jump > $end){
                break;
            }
            
            $tanggal = Carbon::parse($tanggalPemeriksaan);

            $waktuPemeriksaan = $tanggal
                ->copy()
                ->setTimeFrom($jamBuka);
                $now = Carbon::now();
                
            $diffInHours = $now->diffInHours($waktuPemeriksaan, false);
            if ($diffInHours < -1) {
                $start += $jump;
                $jamBuka->addHour($jump);
                continue;
            }
            $listJam[] = $jamBuka->format('H:i');
            $jamBuka->addHour($jump);
            $start += $jump;
        }
        
        $slots['listJam'] = $listJam;

        return $slots;
    }

    //buat dapetin hari apa aja yang jadwalnya uda penuh
    public function jadwalPenuh($jenisPemeriksaan)
    {
        $unavailable = [];
        $startDate = today();
        $endDate   = today()->addDays(31);

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $tanggal = $date->toDateString();

            $dayIndex = $date->isoWeekday();

            $jadwal = $this->jadwalRumahSakit()
                ->firstWhere('indexJadwal', $dayIndex);

            if (!$jadwal || !$jadwal->buka) {
                $unavailable[] = $tanggal;
                continue;
            }

            $result = $this->jamTersedia($jenisPemeriksaan, $tanggal);
            $listJam = $result['listJam'] ?? [];

            if (empty($listJam)) {
                $unavailable[] = $tanggal;
            }
        }

        return $unavailable;
    }

    //dapetin hari mana aja yang rumah sakitnya tutup
    public function jadwalPenuhPetugas($jenisPemeriksaan)
    {
        $unavailable = [];
        $startDate = today();
        $endDate   = today()->addDays(31);

        $period = CarbonPeriod::create($startDate, $endDate);

        foreach ($period as $date) {
            $tanggal = $date->toDateString();

            $dayIndex = $date->isoWeekday();

            $jadwal = $this->jadwalRumahSakit()
                ->firstWhere('indexJadwal', $dayIndex);

            if (!$jadwal || !$jadwal->buka) {
                $unavailable[] = $tanggal;
                continue;
            }

            $result = $this->jamTersediaPetugas($jenisPemeriksaan, $tanggal);
            $listJam = $result['listJam'] ?? [];

            if (empty($listJam)) {
                $unavailable[] = $tanggal;
            }
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

    public function counterAntrian()
    {
        return $this->hasMany(CounterAntrian::class);
    }

    public function counterHariIni($kelompokJenisPemeriksaanId){
        return $this->counterAntrian()
                    ->whereDate('tanggalAntrian', Carbon::today())
                    ->where('kelompok_jenis_pemeriksaan_id', $kelompokJenisPemeriksaanId)
                    ->first();
    }

    public function dataDalamPemeriksaan($kelompokJenisPemeriksaanId){
        return $this->dataPemeriksaan()
                    ->where('statusPasien', 'Pemeriksaan Berlangsung')
                    ->whereHas('jenisPemeriksaan.kelompokJenisPemeriksaan', function ($query) use ($kelompokJenisPemeriksaanId) {
                        $query->where('id', $kelompokJenisPemeriksaanId);
                    });
        // return $this->dataPemeriksaan()
        //             ->where('statusPasien', 'Pemeriksaan Berlangsung')
        //             ->whereHas('jenisPemeriksaan', function($query) use ($namaJenisPemeriksaan) {
        //                 $query->where('namaJenisPemeriksaan', $namaJenisPemeriksaan);
        //             })
        //             ->first();
    }

    public function dataDalamAntrian($kelompokJenisPemeriksaanId){
        return $this->dataPemeriksaan()
                    ->where('statusPasien', 'Dalam Antrian')
                    ->whereHas('jenisPemeriksaan.kelompokJenisPemeriksaan', function ($query) use ($kelompokJenisPemeriksaanId) {
                        $query->where('id', $kelompokJenisPemeriksaanId);
                    })
                    ->orderBy('nomorAntrian', 'asc');
    }


}
