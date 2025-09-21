<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalDokter extends Model
{
    protected $fillable = [
        'dokter_id',
        'indexJadwal',
        'jamMulai',
        'jamSelesai',
        'kerja',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function getNamaHariAttribute()
    {
        $days = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
            7 => 'Minggu',
        ];

        //kalo indexnya bukan 1-7, keluarin -
        return $days[$this->indexJadwal] ?? '-';
    }
}
