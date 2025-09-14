<?php

namespace App\Http\Controllers;

use App\Models\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendaftaranController extends Controller
{
    // STEP 1: Pilih Jadwal
    public function index(Request $request)
    {
        $rumahsakits = RumahSakit::orderBy('nama')->get(['id','nama', 'jamBuka', 'jamTutup', 'jumlahPasien']);
        
        $rsId = $request->query('rumah');


    }




}
