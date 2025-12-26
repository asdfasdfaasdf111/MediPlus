<?php

namespace Database\Seeders;

use App\Models\KelompokJenisPemeriksaan;
use App\Models\RumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelompokJenisPemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahSakit = RumahSakit::first();

        $dataNama = [
            'CT Scan',
            'Mamografi',
            'MRI',
            'X-Ray'];

        for ($i = 0; $i < 4; $i++){
            KelompokJenisPemeriksaan::create([
                'rumah_sakit_id' => $rumahSakit->id,
                'namaKelompok' => $dataNama[$i]
            ]);
        }
    }
}