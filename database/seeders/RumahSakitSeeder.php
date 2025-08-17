<?php

namespace Database\Seeders;

use App\Models\JadwalRumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use App\Models\RumahSakit;

class RumahSakitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = SuperAdmin::first();

        $rumahSakit = RumahSakit::create([
            'nama' => 'RS Mitra Medika',
            'alamat' => 'Jl. Tanjung Duren No. 123, Jakarta Barat',
            'noTelepon' => '021-123456',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
        ]);

        for ($i = 1; $i <= 7; $i++){
            JadwalRumahSakit::create([
                'rumah_sakit_id' => $rumahSakit->id,
                'indexJadwal' => $i,
                'jamBuka' => '08:00:00',
                'jamTutup' => '17:00:00',
            ]);
        }
    }
}
