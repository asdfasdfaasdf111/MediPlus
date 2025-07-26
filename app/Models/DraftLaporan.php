<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DraftLaporan extends Model
{
    protected $fillable = [
        'dokter_id',
        'judul',
        'deskripsi'
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}
