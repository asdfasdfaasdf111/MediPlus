<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugass';
    protected $fillable = [
        'noHP',
        'user_id',
        'admin_id',
        'rumah_sakit_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function log()
    {
        return $this->hasMany(Log::class);
    }

    public function dataPemeriksaan()
    {
        return $this->hasMany(DataPemeriksaan::class, 'rumah_sakit_id', 'rumah_sakit_id')
        ->ordered('statusPetugas');
    }

    public function jenisPemeriksaan()
    {
        return $this->hasMany(JenisPemeriksaan::class, 'rumah_sakit_id', 'rumah_sakit_id');
    }

}
