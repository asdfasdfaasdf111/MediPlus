<?php

namespace Database\Seeders;

use App\Models\Modalitas;
use App\Models\RumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModalitasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahSakit = RumahSakit::first();
        $kelompokJenisPemeriksaan = $rumahSakit
        ->kelompokJenisPemeriksaan()
        ->first();

        for ($i = 0; $i < 2; $i++){
            Modalitas::create([
                'rumah_sakit_id' => $rumahSakit->id,
                'namaModalitas' => 'CT-'.$i,
                'kelompok_jenis_pemeriksaan_id' => $kelompokJenisPemeriksaan->id,
                'kodeRuang' => 'CT',
            ]);
        }
    }
}