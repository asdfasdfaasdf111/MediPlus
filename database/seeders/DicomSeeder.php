<?php

namespace Database\Seeders;

use App\Models\Dicom;
use App\Models\Modalitas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DicomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modalitas = Modalitas::first();
        $rumahSakit = $modalitas->rumahSakit;

        for ($i = 0; $i < 5; $i++){
            Dicom::create([
                'modalitas_id' => $modalitas->id,
                'rumah_sakit_id' => $rumahSakit->id,
                'alamatIP' => $modalitas->alamatIP,
                'netMask' => '255.255.255.'.$i,
                'layananDicom' => 'send',
                'peran' => 'send',
                'AET' => 'MRC26266',
                'port' => 80,
            ]);
        }
        
    }
}
