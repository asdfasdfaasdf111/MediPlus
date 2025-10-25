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
        $dataNama = [
            'Mitra Medika', 
            'UKRIDA', 
            'Jakarta', 
            'Siloam', 
            'Anggrek Mas',
            'Metro Hospitals Kebon Jeruk'];
        $dataAlamat = [
            'Jl. Tanjung Duren No. 123, Jakarta Barat',
            'Jl. Arjuna Utara No.6, RT.6/RW.2, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat',
            'Jl. Jend. Sudirman No.Kav. 49, RT.5/RW.4, Karet Semanggi',
            'Jl. Perjuangan No.Kav.8, Kb. Jeruk, Kec. Kb. Jeruk',
            'Jl. Anggrek No.2B, RT.9/RW.2, Klp. Dua, Kec. Kb. Jeruk',
            'Jl. Duri Raya No.22, RT.2/RW.7, Duri Kepa'];
        $dataNoTelepon = [
            '021-123456',
            '021-39723777',
            '021-5732241',
            '1 500 911',
            '021-5305720',
            '0811-1800-207'
        ];
        for ($i = 0; $i < count($dataNama); $i++){
            $rumahSakit = RumahSakit::create([
                'nama' => $dataNama[$i],
                'alamat' => $dataAlamat[$i],
                'noTelepon' => $dataNoTelepon[$i],
                'super_admin_id' => $superadmin->id
            ]);
            for ($j = 1; $j <= 7; $j++){
                JadwalRumahSakit::create([
                    'rumah_sakit_id' => $rumahSakit->id,
                    'indexJadwal' => $j,
                    'jamBuka' => '08:00:00',
                    'jamTutup' => '17:00:00',
                    'buka' => ($j <= 5 ? true : false),
                ]);
            }
        }
    }
}