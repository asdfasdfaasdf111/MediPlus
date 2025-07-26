<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $user = User::create([
            'name'=>'SuperAdmin',
            'email'=>'superadmin@gmail.com',
            'password'=>Hash::make('12345'),
            'role'=>'superadmin',
            'status'=>'aktif',
            'email_verified_at' => now(),
       ]);

       SuperAdmin::create([
        'user_id'=>$user->id,
       ]);

    }
}
