<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\MasterPasien;
use App\Models\Pasien;
use App\Models\RumahSakit;

class PasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahsakit = RumahSakit::first();

        $user = User::create([
            'name' => 'Tiara Intan Kusuma',
            'email' => 'titi@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 'pasien',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        $masterpasien = MasterPasien::create([
            'user_id' => $user->id
        ]);

        $pasien = Pasien::create([
            'rumah_sakit_id' => $rumahsakit->id,
            'master_pasien_id' => $masterpasien->id,
            'alamatDomisili' => 'Jalan K. H. Syahdan, No. 456, Jakarta Barat',
            'tanggalLahir' => '2004-04-19',
            'noIdentitas' => '01234567891011',
            'jenisIdentitas' => 'KTP',
            'jenisKelamin' => 'Perempuan',
            'noHP' => '08123456789',
            'alergi' => 'Udang',
            'golonganDarah' => 'O',
            'nomorRekamMedis' => 'REC-123'
        ]);
    }
}
