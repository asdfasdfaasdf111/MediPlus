<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterPasien extends Model
{
    protected $table = 'master_pasiens';
    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dataPasien()
    {
        return $this->hasMany(DataPasien::class);
    }
}
