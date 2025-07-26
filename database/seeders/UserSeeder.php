<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {      
        // $user = User::create([
        // 'name' => 'Leo',
        // 'email' => 'leo@gmail.com',
        // 'password' => Hash::make('leo123'),
        // 'role' => 'Admin',
        // ]);

        // Admin::create([
        //     'user_id' => $user->id,
        // ]);
    }

    

}
