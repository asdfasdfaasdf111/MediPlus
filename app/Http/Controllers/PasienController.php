<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RumahSakit;
use App\Models\User;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function homepage(){
        $data = RumahSakit::orderBy('nama', 'asc')->get();

        return view('pasien.homepage', ['rumahsakits'=> $data]);
    }

    public function submitEmailPasien(Request $request){
        if (!User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Tidak terdapat pasien dengan email ini.'])->withInput();
        }
        $user = User::where('email', $request->email)->first();
        if ($user->role !== 'pasien'){
            return back()->withErrors(['email' => 'Tidak terdapat pasien dengan email ini.'])->withInput();
        }

        return redirect()->route('petugas.daftarpilihjadwal', ['user' => $user->id]);
    }
}
