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

        Modalitas::create([
            'rumah_sakit_id' => $rumahSakit->id,
            'namaModalitas' => 'AX',
            'jenisModalitas' => 'Siemens',
            'merekModalitas' => 'Angiografi',
            'tipeModalitas' => 'Artis zee floor',
            'nomorSeriModalitas' => '136957',
            'kodeRuang' => 'R001',
            'alamatIP' => '192.0.0.3',
        ]);
    }
}
