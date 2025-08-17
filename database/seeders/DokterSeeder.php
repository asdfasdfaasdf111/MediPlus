<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Dokter;
use App\Models\JadwalDokter;
use App\Models\RumahSakit;
use App\Models\Spesialis;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
   
    public function run(): void
    {
        $spesialis = Spesialis::first();
        $rumahsakit = $spesialis->rumahsakit;
        $admin = $rumahsakit->admin;

        $user = User::create([
            'name'=>'Dr. Leonardo Dahendra',
            'email'=>'leonardodahendra@gmail.com',
            'password'=>Hash::make('12345'),
            'role'=>'dokter',
            'status'=>'aktif',
            'email_verified_at' => now(),
       ]);

        $dokter = Dokter::create([
            'user_id'=>$user->id,
            'admin_id'=>$admin->id,
            'rumah_sakit_id'=>$rumahsakit->id,
            'spesialis_id'=>$spesialis->id,
            'noHP'=>'081234567890'
        ]);


        for ($i = 1; $i <= 7; $i++){
            JadwalDokter::create([
                'dokter_id' => $dokter->id,
                'indexJadwal' => $i,
                'jamMulai' => '08:00:00',
                'jamSelesai' => '17:00:00',
            ]);
        }

       for ($i = 0; $i < 10; $i++){
            $user = User::create([
                'name'=>'Dr. D'.$i,
                'email'=>'D'.$i.'@gmail.com',
                'password'=>Hash::make('12345'),
                'role'=>'dokter',
                'status'=>'aktif',
                'email_verified_at' => now(),
            ]);

            $dokter = Dokter::create([
                'user_id'=>$user->id,
                'admin_id'=>$admin->id,
                'rumah_sakit_id'=>$rumahsakit->id,
                'spesialis_id'=>$spesialis->id,
                'noHP'=>'081234567890'
            ]);

            for ($j = 1; $j <= 7; $j++){
                JadwalDokter::create([
                    'dokter_id' => $dokter->id,
                    'indexJadwal' => $j,
                    'jamMulai' => '08:00:00',
                    'jamSelesai' => '17:00:00',
                ]);
            }
       }
    }
}
