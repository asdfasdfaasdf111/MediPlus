<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'data_pemeriksaan_id',
        'order_id',
        'metodePembayaran',
        'mediaPembayaran',
        'status',
        'harga',
        'namaJenisPemeriksaan',
        'namaPasien',
        'emailPasien',
        'checkoutLink',
    ];

    public function dataPemeriksaan()
    {
        return $this->belongsTo(DataPemeriksaan::class);
    }
}
