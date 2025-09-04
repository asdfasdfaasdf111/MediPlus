<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
        'status'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function pasien()
    {
        return $this->hasOne(Pasien::class);
    }

    public function masterPasien()
    {
        return $this->hasOne(MasterPasien::class);
    }

    public function dokter()
    {
        return $this->hasOne(Dokter::class);
    }

    public function petugas()
    {
        return $this->hasOne(Petugas::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function superadmin()
    {
        return $this->hasOne(SuperAdmin::class);
    }
}
