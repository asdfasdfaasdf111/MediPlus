<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuperAdmin extends Model
{

    protected $fillable = [
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rumahsakit()
    {
        return $this->hasMany(RumahSakit::class);
    }

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }
}
