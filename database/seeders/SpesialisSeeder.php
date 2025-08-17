<?php

namespace Database\Seeders;

use App\Models\RumahSakit;
use App\Models\Spesialis;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpesialisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rumahsakit = RumahSakit::first();
        //
        Spesialis::create([
            'rumah_sakit_id' => $rumahsakit->id,
            'namaSpesialis' => 'USG'
        ]);
    }
}
