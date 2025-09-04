<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dicom extends Model
{
    protected $fillable = [
        'modalitas_id',
        'rumah_sakit_id',
        'alamatIP',
        'netMask',
        'layananDicom',
        'peran',
        'AET',
        'port'
    ];

    public function modalitas()
    {
        return $this->belongsTo(Modalitas::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }
}
