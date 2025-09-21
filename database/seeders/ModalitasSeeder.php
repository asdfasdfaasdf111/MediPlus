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

        for ($i = 0; $i < 5; $i++){
            Modalitas::create([
                'rumah_sakit_id' => $rumahSakit->id,
                'namaModalitas' => 'AX'.$i,
                'jenisModalitas' => 'Siemens',
                'kodeRuang' => 'R001',
            ]);
        }
    }
}
