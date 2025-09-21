<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'rumah_sakit_id',
        'super_admin_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function superAdmin()
    {
        return $this->belongsTo(superadmin::class);
    }

    public function petugas()
    {
        return $this->hasMany(Petugas::class);
    }

    public function dokter()
    {
        return $this->hasMany(Dokter::class);
    }
}
