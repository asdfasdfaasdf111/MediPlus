<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Petugas;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //pke service
    // public function bikinLog($petugasId, $aktivitas){
    //     $petugas = Petugas::find($petugasId);
    //     Log::create([
    //         'aktivitas' => $aktivitas,
    //         'jam' => Carbon::now()->format('H:i:s'),
    //         'tanggal' => Carbon::today()->format('Y-m-d'),
    //         'petugas_id' => $petugasId,
    //         'rumah_sakit_id' => $petugas->rumahSakit->id
    //     ]);
    // }
}
