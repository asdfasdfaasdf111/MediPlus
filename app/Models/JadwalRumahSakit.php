<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalRumahSakit extends Model
{
    protected $fillable = [
        'rumah_sakit_id',
        'indexJadwal',
        'jamBuka',
        'jamTutup',
        'buka',
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
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
