<?php

namespace Database\Seeders;

use App\Models\JadwalRumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use App\Models\RumahSakit;

class RumahSakitSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = SuperAdmin::first();

        RumahSakit::insert([
            [
            'nama' => 'Mitra Medika',
            'alamat' => 'Jl. Tanjung Duren No. 123, Jakarta Barat',
            'noTelepon' => '021-123456',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
            ],
            [   
            'nama' => 'UKRIDA',
            'alamat' => 'Jl. Arjuna Utara No.6, RT.6/RW.2, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat',
            'noTelepon' => '021-39723777',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
            ],
            [
            'nama' => 'Jakarta',
            'alamat' => 'Jl. Jend. Sudirman No.Kav. 49, RT.5/RW.4, Karet Semanggi',
            'noTelepon' => '021-5732241',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
            ],
            [   
            'nama' => 'Siloam',
            'alamat' => 'Jl. Perjuangan No.Kav.8, Kb. Jeruk, Kec. Kb. Jeruk',
            'noTelepon' => '1 500 911',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
            ],
            [
            'nama' => 'Anggrek Mas',
            'alamat' => 'Jl. Anggrek No.2B, RT.9/RW.2, Klp. Dua, Kec. Kb. Jeruk',
            'noTelepon' => '021-5305720',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
            ],
            [   
            'nama' => 'Metro Hospitals Kebon Jeruk',
            'alamat' => 'Jl. Duri Raya No.22, RT.2/RW.7, Duri Kepa',
            'noTelepon' => '0811-1800-207',
            'jumlahPasien' => 5,
            'super_admin_id' => $superadmin->id
            ]
    ]);
    }
}
