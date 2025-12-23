<?php

namespace Database\Seeders;

use App\Models\JenisPemeriksaan;
use App\Models\Modalitas;
use App\Models\RumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisPemeriksaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $modalitas = Modalitas::first();
        $rumahSakit = RumahSakit::first();
        $kelompokJenisPemeriksaan = $rumahSakit
        ->kelompokJenisPemeriksaan()
        ->first();

        for ($i = 0; $i < 10; $i++){
            JenisPemeriksaan::create([
                // 'modalitas_id' => $modalitas->id,
                'rumah_sakit_id' => $rumahSakit->id,
                'kelompok_jenis_pemeriksaan_id' => $kelompokJenisPemeriksaan->id,
                'namaJenisPemeriksaan' => 'Oesofagografi'.$i,
                'pemakaianKontras' => false,
                'lamaPemeriksaan' => ($i + 1) * 10,
                'diDampingiDokter' => true,
            ]);
        }
        
    }
}
