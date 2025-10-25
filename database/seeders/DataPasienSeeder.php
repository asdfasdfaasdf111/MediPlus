<?php

namespace Database\Seeders;

use App\Models\MasterPasien;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataPasienSeeder extends Seeder
{
    public function run(): void
    {
        // 1) buat akun pasien
        $user = User::create([
            'name'              => 'Tiara Intan Kusuma',
            'email'             => 'titi@gmail.com',
            'password'          => Hash::make('12345'),
            'role'              => 'pasien',
            'status'            => 'aktif',
            'email_verified_at' => now(),
        ]);

        $masterpasien = MasterPasien::create([
            'user_id' => $user->id
        ]);

        DataPasien::create([
            'master_pasien_id' => $masterpasien->id,
            'namaLengkap' => 'Titi Kusuma',
            'alamatDomisili' => 'Jalan K. H. Syahdan, No. 456, Jakarta Barat',
            'tanggalLahir' => '2004-04-19',
            'noIdentitas' => '01234567891011',
            'jenisIdentitas' => 'KTP',
            'jenisKelamin' => 'Perempuan',
            'noHP' => '08123456789',
            'alergi' => 'Udang',
            'golonganDarah' => 'O',
        ]);
    }
}
