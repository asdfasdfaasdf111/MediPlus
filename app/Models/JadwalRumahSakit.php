<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalRumahSakit extends Model
{
    protected $fillable = [
        'rumah_sakit_id',
        'indexJadwal',
        'jamBuka',
        'jamTutup'
    ];

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }
}
