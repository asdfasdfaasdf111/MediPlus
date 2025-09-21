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

    public function rumahSakit()
    {
        return $this->hasMany(RumahSakit::class);
    }

    public function admin()
    {
        return $this->hasMany(Admin::class);
    }
}
