<?php

namespace Database\Seeders;

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

        RumahSakit::create([
            'nama' => 'RS Mitra Medika',
            'alamat' => 'Jl. Tanjung Duren No. 123, Jakarta Barat',
            'noTelepon' => '021-123456',
            'jamBuka' => '08:00:00',
            'jamTutup' => '23:00:00',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
        ]);
    }
}
