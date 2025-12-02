<?php

namespace Database\Seeders;

use App\Models\DataPasien;
use App\Models\DataRujukan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataRujukanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $dataPasien = DataPasien::first();
        DataRujukan::create([
            'data_pasien_id' => $dataPasien->id,
            'namaFaskes' => 'Faskes A',
            'namaDokterPerujuk' => 'Dokter A',
            'diagnosaKerja' => 'Bro Sakit',
            'alasanRujukan' => 'Perlu scan',
            'tanggalPemeriksaanFaskes' => now()->toDateString(),
            'permintaanPemeriksaan' => 'CT-Scan',
            'formulirRujukan' => 'file/rujukan/rujukanA',
            'namaFile' => 'rujukanA',
        ]);
    }
}