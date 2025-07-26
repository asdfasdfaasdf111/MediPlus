<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\RumahSakit;
use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahsakit = RumahSakit::first();
        $superadmin = SuperAdmin::first();

        $user = User::create([
            'name' => 'Admin1',
            'email' => 'admin1@gmail.com',
            'password' => Hash::make('12345'),
            'role' => 'admin',
            'status' => 'aktif',
            'email_verified_at' => now(),
        ]);

        Admin::create([
            'user_id' => $user->id,
            'rumah_sakit_id' => $rumahsakit->id,
            'super_admin_id' => $superadmin->id,
        ]);
    }
}
