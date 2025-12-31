<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Dokter extends Model
{
    protected $fillable = [
        'user_id',
        'rumah_sakit_id',
        'admin_id',
        'spesialis',
        'noHP',
        'foto',
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
        return $this->hasMany(DataPemeriksaan::class)
        ->whereIn('statusUtama', ['Berlangsung', 'Selesai'])
        // ->whereNotIn('statusDokter', [
        //     'Menunggu Registrasi Ulang',
        //     'Menunggu Pembayaran Offline',
        // ])
        ->ordered('statusDokter');
    }


    public function hasilPemeriksaan()
    {
        return $this->hasMany(HasilPemeriksaan::class);
    }

    public function jadwalDokter()
    {
        return $this->hasMany(JadwalDokter::class)
                    ->orderBy('indexJadwal', 'asc');;
    }

    public function available($tanggalPemeriksaan, $time, $duration, $jenisPemeriksaan)
    {
        if (!$jenisPemeriksaan->diDampingiDokter){
            return true;
        }
        $hariIni = Carbon::parse($tanggalPemeriksaan)->isoWeekday();
        $hariIni = $this->jadwalDokter()
                        ->where('indexJadwal', $hariIni)
                        ->first();

        //kalo hari ini ga kerja, atau jadwalnya diluar jam kerja si dokter, berarti dia ga available
        if (!$hariIni->kerja) return false;
        $start = strtotime($hariIni->jamMulai);
        $end   = strtotime($hariIni->jamSelesai);

        // klo 00:00 anggap 24:00
        if (date('H:i', $end) === '00:00') {
            $end = strtotime('+1 day', $end);
        }

        $timeStart = strtotime($time);
        $timeEnd   = $timeStart + $duration;

        if ($timeStart < $start || $timeEnd > $end) {
            return false;
        }
        $dataPemeriksaans = $this->dataPemeriksaan()
                                ->where('tanggalPemeriksaan', $tanggalPemeriksaan)->get();
        $penggunaanKuota = array_fill(0, 24, 0);
        foreach ($dataPemeriksaans as $data) {
            if (!$jenisPemeriksaan->diDampingiDokter) continue;
            $index = Carbon::parse($data->rentangWaktuKedatangan)->hour;
            $dur = $data->jenisPemeriksaan->lamaPemeriksaan;
            while($dur > 0){
                $penggunaanKuota[$index] += min($dur, 60);
                $dur -= 60;
                $index++;
            }
        }
        $jump = $jenisPemeriksaan->getJump();
        $index = Carbon::parse($time)->hour;
        $totalJam = 0;
        for ($i = $index; $i < min($index + $jump, 24); $i++){
            $totalJam += $penggunaanKuota[$i];
        }
        if ($totalJam + $duration <= 60 * $jump){
            return true;
        }
        return false;
    }
}