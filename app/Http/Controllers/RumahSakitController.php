<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RumahSakitController extends Controller
{
    public function updateJadwal(Request $request){
        $request->validate([
            'jamBuka' => 'required|date_format:H:i',
            'jamTutup' => 'required|date_format:H:i|after:jamBuka',
        ]);

        $admin = auth()->user()->admin;
        $admin->rumahSakit->updateJadwal($request->jamBuka, $request->jamTutup);
        return redirect(route('admin.kelolajadwalpage'));
    }

    public function updateJumlahPasien(Request $request){
        $request->validate([
            'jumlahPasien' => 'required|numeric|min:1',
        ]);

        $admin = auth()->user()->admin;
        $admin->rumahSakit->updateJumlahPasien($request->jumlahPasien);
        return redirect(route('admin.kelolajadwalpage'));
    }
}
