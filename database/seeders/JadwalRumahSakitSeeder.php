<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalRumahSakitSeeder extends Seeder
{
    public function run(): void
    {
        // hindari duplikasi
        if (DB::table('jadwal_rumah_sakits')->exists()) return;

        $rsIds = DB::table('rumah_sakits')->pluck('id');

        foreach ($rsIds as $rsId) {
            // Senin(1) - Jumat(5): 08:00 - 17:00, buka
            for ($d=1; $d<=5; $d++) {
                DB::table('jadwal_rumah_sakits')->insert([
                    'rumah_sakit_id' => $rsId,
                    'indexJadwal'    => $d,
                    'jamBuka'        => '08:00:00',
                    'jamTutup'       => '17:00:00',
                    'buka'           => true,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
            // Sabtu(6): 08:00 - 12:00, buka
            DB::table('jadwal_rumah_sakits')->insert([
                'rumah_sakit_id' => $rsId,
                'indexJadwal'    => 6,
                'jamBuka'        => '08:00:00',
                'jamTutup'       => '12:00:00',
                'buka'           => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
            // Minggu(7): tutup
            DB::table('jadwal_rumah_sakits')->insert([
                'rumah_sakit_id' => $rsId,
                'indexJadwal'    => 7,
                'jamBuka'        => '00:00:00',
                'jamTutup'       => '00:00:00',
                'buka'           => false,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
