<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DataPemeriksaan extends Model
{
    protected $fillable = [
        'dokter_id',
        'jenis_pemeriksaan_id',
        'data_pasien_id',
        'rumah_sakit_id',
        'data_rujukan_id',
        'master_pasien_id',
        'modalitas_id',
        'tanggalPemeriksaan',
        'rentangWaktuKedatangan',
        'namaPendamping',
        'nomorPendamping',
        'hubunganPendamping',
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
        'nomorAntrian',
        'cancelled_at',
    ];

    protected $casts = [
        'cancelled_at' => 'datetime',
    ];

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function jenisPemeriksaan()
    {
        return $this->belongsTo(JenisPemeriksaan::class);
    }

    public function modalitas()
    {
        return $this->belongsTo(Modalitas::class);
    }

    public function dataPasien()
    {
        return $this->belongsTo(DataPasien::class);
    }

    public function masterPasien()
    {
        return $this->belongsTo(MasterPasien::class);
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
        //yang draft ga bakal keliatan, cuma biar sistem bisa nyimpan datanya aja
        $statusUtama = "'Draft','Pending','Berlangsung','Selesai', 'Dibatalkan'";

        switch ($subtype) {
            case 'statusPasien':
                $statusUser = "'Pendaftaran Terkirim','Menunggu Registrasi Ulang','Dalam Antrian', 'Pemeriksaan Berlangsung', 'Menunggu Hasil', 'Hasil Tersedia', 'Pendaftaran Dibatalkan'";
                break;
            case 'statusPetugas':
                $statusUser = "'Pendaftaran Baru','Menunggu Registrasi Ulang','Dalam Antrian','Pemeriksaan Berlangsung','Menunggu Laporan', 'Laporan Terkirim', 'Pendaftaran Dibatalkan'";
                break;
            case 'statusDokter':
                $statusUser = "'Dalam Antrian','Pemeriksaan Berlangsung','Menunggu Laporan', 'Laporan Terkirim', 'Pendaftaran Dibatalkan'";
                break;
            default:
                $statusUser = "'default'";
        }

        return $query->orderByRaw("FIELD(statusUtama, $statusUtama)")
                    ->orderByRaw("FIELD($subtype, $statusUser)")
                    ->orderBy('tanggalPemeriksaan')
                    ->orderBy('rentangWaktuKedatangan');
    }

        public function tanggalHuman(): ?string
    {
        return $this->tanggalPemeriksaan
            ? Carbon::parse($this->tanggalPemeriksaan)->translatedFormat('d F Y')
            : null;
    }

    public function waktuKedatanganHuman(): ?string
    {
        // kolom kamu bertipe TIME tunggal; tampilkan H : i
        return $this->rentangWaktuKedatangan
            ? Carbon::parse($this->rentangWaktuKedatangan)->format('H : i')
            : null;
    }

    public function scopeBerlangsung($q)
    {
        return $q->whereNotIn('statusUtama', ['selesai','batal']);
    }

    public function bisaDiedit(){
        if ($this->statusUtama != "Pending") return false;
        $datetime = $this->tanggalPemeriksaan . ' ' . $this->rentangWaktuKedatangan;

        $givenTime = Carbon::parse($datetime);

        $now = Carbon::now();

        $hoursDiff = $now->diffInHours($givenTime, false);
        
        return $hoursDiff >= 12;
    }

    public function cancelPendaftaran($catatan, $statusPasien, $statusPetugas = null, $statusDokter = null){
        if ($this->statusUtama === 'Dibatalkan') {
            return false;
        }
        if (empty($statusPetugas)){
            $statusPetugas = $statusPasien;
        }
        if (empty($statusDokter)){
            $statusDokter = $statusPasien;
        }

        $this->update([
            'statusUtama' => 'Dibatalkan',
            'statusPasien' => $statusPasien,
            'statusPetugas' => $statusPetugas,
            'statusDokter' => $statusDokter,
            'catatanPetugas' => $catatan,
            'cancelled_at' => now(),
        ]);
        return true;
    }
}
