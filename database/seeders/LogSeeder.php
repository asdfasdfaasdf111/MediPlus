<?php

namespace Database\Seeders;

use App\Models\Log;
use App\Models\Petugas;
use App\Models\RumahSakit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahsakit = RumahSakit::first();
        $petugas = Petugas::first();

        for ($i = 1; $i <= 20; $i++){
            Log::create([
                'aktivitas'=>"Dummy Activity".$i,
                'jam'=>now()->toTimeString(),
                'tanggal'=>now()->toDateString(),
                'petugas_id'=>$petugas->id,
                'rumah_sakit_id'=>$rumahsakit->id
            ]);
        }
        
    }
}
