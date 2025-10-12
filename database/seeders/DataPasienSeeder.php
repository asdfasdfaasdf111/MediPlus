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

        // 2) buat master_pasien untuk user tsb
        MasterPasien::create([
            'user_id' => $user->id,
        ]);

        // 3) TIDAK membuat DataPasien → supaya ditambahkan via halaman pendaftaran
    }
}
