<?php

namespace Database\Seeders;

use App\Models\DataPasien;
use App\Models\MasterPasien;
use App\Models\RumahSakit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataPasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        DataPasien::create([
            'master_pasien_id' => $masterpasien->id,
            'namaLengkap' => 'Johnny Frans',
            'alamatDomisili' => 'Jl. Palapa III D No.12',
            'tanggalLahir' => '1954-03-05',
            'noIdentitas' => '6171030554660006',
            'jenisIdentitas' => 'KTP',
            'jenisKelamin' => 'Laki-laki',
            'noHP' => '0811578788',
            'alergi' => 'Udang',
            'golonganDarah' => 'A',
            'hubunganKeluarga' => 'Orang Tua',
        ]);
    }
}