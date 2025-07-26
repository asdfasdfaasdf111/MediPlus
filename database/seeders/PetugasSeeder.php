<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Petugas;
use App\Models\User;
use App\Models\RumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    
    public function run(): void
    {
        $admin = Admin::first();
        $rumahsakit = RumahSakit::first();

        $user = User::create([
            'name'=> 'Evelyn Angelica',
            'email'=> 'evelynangelica@gmail.com',
            'password'=> Hash::make('12345'),
            'role'=> 'petugas',
            'status'=> 'aktif',
            'email_verified_at' => now(),
        ]);

        Petugas::create([
            'user_id'=>$user->id,
            'admin_id'=>$admin->id,
            'rumah_sakit_id'=> $rumahsakit->id,
            'noHP'=>'081234567890'
        ]);
    }
}
