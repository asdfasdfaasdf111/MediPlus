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

    public function submitEmailPasien(Request $request)
    {
        $request->validate(
            [
                'email' => ['required', 'email'],
            ],
            [
                'email.required' => 'Email pasien wajib diisi.',
                'email.email' => 'Format email tidak valid.',
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user || $user->role !== 'pasien') {
            return back()
                ->withErrors(['email' => 'Tidak terdapat pasien dengan email ini.'])
                ->withInput();
        }

        return redirect()->route('petugas.daftarpilihjadwal', ['user' => $user->id]);
    }

}