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
        $modalitas = Modalitas::first();
        $rumahSakit = $modalitas->rumahSakit;

        JenisPemeriksaan::create([
            'modalitas_id' => $modalitas->id,
            'rumah_sakit_id' => $rumahSakit->id,
            'namaJenisPemeriksaan' => 'SISTEM PENCERNAAN',
            'namaPemeriksaanSpesifik' => 'Oesofagografi',
            'kelompokJenisPemeriksaan' => 'XP-F',
            'pemakaianKontras' => false,
            'lamaPemeriksaan' => '01:00:00',
            'diDampingiDokter' => true,
        ]);
    }
}
