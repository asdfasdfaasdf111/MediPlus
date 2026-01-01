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
        $kelompokJenisPemeriksaan = $rumahSakit->kelompokJenisPemeriksaan;

        foreach ($kelompokJenisPemeriksaan as $kelompok) {

            $jenis = [];

            switch ($kelompok->namaKelompok) {

                case 'CT Scan':
                    $jenis = [
                        ['CT Scan Kepala Non Kontras', false, 15, true, 1200000],
                        ['CT Scan Kepala Dengan Kontras', true, 20, true, 1500000],
                        ['CT Scan Abdomen', true, 25, true, 1800000],
                    ];
                    break;

                case 'MRI':
                    $jenis = [
                        ['MRI Otak Tanpa Kontras', false, 45, true, 2500000],
                        ['MRI Otak Dengan Kontras', true, 60, true, 3000000],
                        ['MRI Spine Lumbal', false, 45, true, 2800000],
                    ];
                    break;

                case 'USG':
                    $jenis = [
                        ['USG Abdomen Atas', false, 15, false, 450000],
                        ['USG Doppler Pembuluh Darah', false, 30, true, 750000],
                    ];
                    break;

                case 'Rontgen':
                    $jenis = [
                        ['Rontgen Thorax PA', false, 10, false, 250000],
                        ['Rontgen Abdomen', false, 10, false, 300000],
                    ];
                    break;
            }

            foreach ($jenis as $item) {
                JenisPemeriksaan::create([
                    'rumah_sakit_id' => $rumahSakit->id,
                    'kelompok_jenis_pemeriksaan_id' => $kelompok->id,
                    'namaJenisPemeriksaan' => $item[0],
                    'pemakaianKontras' => $item[1],
                    'lamaPemeriksaan' => $item[2],
                    'diDampingiDokter' => $item[3],
                    'harga' => $item[4],
                ]);
            }
        }
    }
}