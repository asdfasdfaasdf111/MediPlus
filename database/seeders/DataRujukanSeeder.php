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
            'namaFaskes' => 'RSUD Soedarso',
            'namaDokterPerujuk' => 'dr. Andi Pratama, Sp.N',
            'diagnosaKerja' => 'Stroke iskemik akibat sumbatan pembuluh darah otak',
            'alasanRujukan' => 'Evaluasi lesi otak dan konfirmasi lokasi sumbatan',
            'tanggalPemeriksaanFaskes' => now()->toDateString(),
            'permintaanPemeriksaan' => 'CT-Scan Kepala Non Kontras',
            'formulirRujukan' => 'file/rujukan/rujukanA',
            'namaFile' => 'rujukanA',
        ]);
    }
}