<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = [
        'aktivitas',
        'jam',
        'tanggal',
        'petugas_id',
        'rumah_sakit_id'
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

}
