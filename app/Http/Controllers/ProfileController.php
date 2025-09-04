<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        // dd($user->name);
        $pasien = $user->pasien;

        // return view('profile.edit', compact('user', 'pasien'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        $request->validate([
            //dari tabel users
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed',
            'status' => 'required|in:aktif,nonaktif',

            //dari tabel pasien
            'alamatDomisili' => 'required|string|max:255',
            'tanggalLahir' => 'required|date',
            'noIdentitas' => 'required|string|max:50',
            'jenisIdentitas' => 'required|string|max:50',
            'jenisKelamin' => 'required|in:Laki-laki,Perempuan',
            'noHP' => 'required|string|max:20',

            //opsional
            'alergi' => 'nullable|string|max:255',
            'golonganDarah' => 'nullable|string|max:3',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = $request->status;

        if($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if($pasien) {
            $pasien->alamatDomisili = $request->alamatDomisili;
            $pasien->tanggalLahir = $request->tanggalLahir;
            $pasien->noIdentitas = $request->noIdentitas;
            $pasien->jenisIdentitas = $request->jenisIdentitas;
            $pasien->jenisKelamin = $request->jenisKelamin;
            $pasien->noHP = $request->noHP;
            $pasien->alergi = $request->alergi;
            $pasien->golonganDarah = $request->golonganDarah;

            $pasien->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
