<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class JenisPemeriksaan extends Model
{
    protected $fillable = [
        'rumah_sakit_id',
        'kelompok_jenis_pemeriksaan_id',
        'namaJenisPemeriksaan',
        'pemakaianKontras',
        'lamaPemeriksaan',
        'diDampingiDokter'
    ];

    public function dataPemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class)
        ->where('statusUtama', '!=', 'Draft')
        ->ordered();
    }

    public function kelompokJenisPemeriksaan()
    {
        return $this->belongsTo(KelompokJenisPemeriksaan::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function getJump()
    {
        $jump = (int) ceil($this->lamaPemeriksaan / 60);
        return $jump;
    }
}
