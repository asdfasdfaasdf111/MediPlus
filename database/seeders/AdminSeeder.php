<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\RumahSakit;
use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = SuperAdmin::first();
        $rumahSakits = RumahSakit::all();

        foreach ($rumahSakits as $index => $rumahSakit) {
            // Buat user untuk admin RS
            $user = User::create([
                'name'              => 'Admin ' . $rumahSakit->nama,
                'email'             => 'admin_rs_' . ($index + 1) . '@gmail.com',
                'password'          => Hash::make('12345'),
                'role'              => 'admin',    
                'status'            => 'aktif',
                'email_verified_at' => now(),
            ]);

            // Hubungkan ke tabel admins
            Admin::create([
                'user_id'        => $user->id,
                'rumah_sakit_id' => $rumahSakit->id,
                'super_admin_id' => $superadmin->id,
            ]);
        }
    }
}
