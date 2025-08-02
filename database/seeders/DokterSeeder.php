<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Dokter;
use App\Models\RumahSakit;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
   
    public function run(): void
    {
        $admin = Admin::first();
        $rumahsakit = RumahSakit::first();

        $user = User::create([
            'name'=>'Dr. Leonardo Dahendra',
            'email'=>'leonardodahendra@gmail.com',
            'password'=>Hash::make('12345'),
            'role'=>'dokter',
            'status'=>'aktif',
            'email_verified_at' => now(),
       ]);

       Dokter::create([
        'user_id'=>$user->id,
        'admin_id'=>$admin->id,
        'rumah_sakit_id'=>$rumahsakit->id,
        'spesialis'=>'USG',
        'noHP'=>'081234567890'
       ]);

       for ($i = 0; $i < 10; $i++){
            $user = User::create([
                'name'=>'Dr. D'.$i,
                'email'=>'D'.$i.'@gmail.com',
                'password'=>Hash::make('12345'),
                'role'=>'dokter',
                'status'=>'aktif',
                'email_verified_at' => now(),
            ]);

            Dokter::create([
                'user_id'=>$user->id,
                'admin_id'=>$admin->id,
                'rumah_sakit_id'=>$rumahsakit->id,
                'spesialis'=>'USG',
                'noHP'=>'081234567890'
            ]);
       }
    }
}
