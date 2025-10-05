<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPemeriksaan extends Model
{
    protected $fillable = [
        'dokter_id',
        'jenis_pemeriksaan_id',
        'data_pasien_id',
        'rumah_sakit_id',
        'data_rujukan_id',
        'tanggalPemeriksaan',
        'rentangWaktuKedatangan',
        'namaPendamping',
        'nomorPendamping',
        'historyJenisPemeriksaan',
        'historyTanggalPemeriksaan',
        'historyJamPemeriksaan',
        'catatanPetugas',
        'statusUtama',
        'statusDokter',
        'statusPetugas',
        'statusPasien',
        'riwayatAlamatDomisili',
        'riwayatTanggalLahir',
        'riwayatJenisKelamin',
        'riwayatNoHP',
        'riwayatAlergi',
        'riwayatGolonganDarah',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->belongsTo(JenisPemeriksaan::class);
    }

    public function dataPasien()
    {
        return $this->belongsTo(DataPasien::class);
    }

    public function rumahSakit()
    {
        return $this->belongsTo(RumahSakit::class);
    }

    public function dataRujukan()
    {
        return $this->belongsTo(DataRujukan::class);
    }

    public function hasilPemeriksaan()
    {
        return $this->hasOne(HasilPemeriksaan::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    //urutin dari status utama, pending dlu, berlangsung, baru selesai
    //kalo status utama sama, urutin dari status pasien/petugas/dokter
    public function scopeOrdered($query, $subtype = 'statusPasien')
    {
        $statusUtama = "'PENDING','BERLANGSUNG','SELESAI'";

        switch ($subtype) {
            case 'statusPasien':
                $statusUser = "'PENDAFTARAN TERKIRIM','MENUNGGU REGISTRASI ULANG','DALAM ANTRIAN', 'HASIL TERSEDIA'";
                break;
            case 'statusPetugas':
                $statusUser = "'PENDAFTARAN BARU','MENUNGGU REGISTRASI ULANG','DALAM ANTRIAN','PEMERIKSAAN BERLANGSUNG'";
                break;
            case 'statusDokter':
                $statusUser = "'DALAM ANTRIAN','PEMERIKSAAN BERLANGSUNG','MENUNGGU LAPORAN'";
                break;
            default:
                $statusUser = "'default'";
        }

        return $query->orderByRaw("FIELD(statusUtama, $statusUtama)")
                    ->orderByRaw("FIELD($subtype, $statusUser)");
    }
}
