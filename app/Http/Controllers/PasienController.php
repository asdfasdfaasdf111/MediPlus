<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function homepage(){
        $data = RumahSakit::orderBy('nama', 'asc')->get();

        return view('pasien.homepage', ['rumahsakits'=> $data]);
    }
}
