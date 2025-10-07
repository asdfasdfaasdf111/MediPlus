<?php

namespace Database\Seeders;

use App\Models\DataPasien;
use App\Models\DataPemeriksaan;
use App\Models\DataRujukan;
use App\Models\RumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $rumahSakit = RumahSakit::first();
        $jenisPemeriksaan = $rumahSakit->jenisPemeriksaan()->first();
        $dataRujukan = DataRujukan::first();
        $dokter = $rumahSakit->dokter()->first();
        $dataPasien = DataPasien::find($dataRujukan->data_pasien_id);
        DataPemeriksaan::create([
            'jenis_pemeriksaan_id' => $jenisPemeriksaan->id,
            'data_pasien_id' => $dataPasien->id,
            'rumah_sakit_id' => $rumahSakit->id,
            'data_rujukan_id' => $dataRujukan->id,
            'tanggalPemeriksaan' => now()->toDateString(),
            'rentangWaktuKedatangan' => '12:00',
            'statusUtama' => 'Pending',
            'statusDokter' => 'Pendaftaran Baru',
            'statusPetugas' => 'Pendaftaran Baru',
            'statusPasien' => 'Pendaftaran Terkirim',
            'riwayatAlamatDomisili' => $dataPasien->alamatDomisili,
            'riwayatTanggalLahir' => $dataPasien->tanggalLahir,
            'riwayatJenisKelamin' => $dataPasien->jenisKelamin,
            'riwayatNoHP' => $dataPasien->noHP,
            'riwayatAlergi' => $dataPasien->alergi,
            'riwayatGolonganDarah' => $dataPasien->golonganDarah,
        ]);
        DataPemeriksaan::create([
            'dokter_id' => $dokter->id,
            'jenis_pemeriksaan_id' => $jenisPemeriksaan->id,
            'data_pasien_id' => $dataPasien->id,
            'rumah_sakit_id' => $rumahSakit->id,
            'data_rujukan_id' => $dataRujukan->id,
            'tanggalPemeriksaan' => now()->toDateString(),
            'rentangWaktuKedatangan' => '12:00',
            'statusUtama' => 'Berlangsung',
            'statusDokter' => 'Menunggu Registrasi Ulang',
            'statusPetugas' => 'Menunggu Registrasi Ulang',
            'statusPasien' => 'Menunggu Registrasi Ulang',
            'riwayatAlamatDomisili' => $dataPasien->alamatDomisili,
            'riwayatTanggalLahir' => $dataPasien->tanggalLahir,
            'riwayatJenisKelamin' => $dataPasien->jenisKelamin,
            'riwayatNoHP' => $dataPasien->noHP,
            'riwayatAlergi' => $dataPasien->alergi,
            'riwayatGolonganDarah' => $dataPasien->golonganDarah,
        ]);
    }
}
