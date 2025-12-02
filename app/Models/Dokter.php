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
        return $this->hasMany(DataPemeriksaan::class)
        ->where('statusUtama', '!=', 'Draft')
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
        if (strtotime($time) < strtotime($hariIni->jamMulai) || strtotime($time) + $duration > strtotime($hariIni->jamSelesai)) return false;

        $dataPemeriksaans = $this->dataPemeriksaan()
                                ->where('rentangWaktuKedatangan', $time)
                                ->where('tanggalPemeriksaan', $tanggalPemeriksaan)->get();
        $totalTime = 0;
        foreach($dataPemeriksaans as $data){
            $jenisPemeriksaan = $data->jenisPemeriksaan;
            if (!$jenisPemeriksaan->diDampingiDokter) continue;
            $totalTime += $jenisPemeriksaan->lamaPemeriksaan;
        }
        if ($totalTime + $duration <= 60) return true;
        return false;
    }
}