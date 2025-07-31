<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

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

    public function countRS(){
        $rumahSakit = RumahSakit::all();
        return view('superadmin.homepage');
    }

    public function addNew(){
        return view('superadmin.homepage');
    }

    public function store(Request $request){
        $request->validate([
            'nama_rs' => 'required',
            'alamat' => 'required',
            'noTelepon' => 'required',

            'nama_admin' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ]);

        $rumahSakit = RumahSakit::create([
            'nama' => $request->nama_rs,
            'alamat' => $request->alamat,
            'noTelepon' => $request->noTelepon
        ]);

        $userAdmin = User::create([
            'name' => $request->nama_admin,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'status' => 'aktif'
        ]);

        Admin::create([
            'user_id' => $userAdmin->id,
            'rumah_sakit_id' => $rumahSakit->id,
            'super_admin_id' => auth()->id()
        ]);

        return redirect(route('superadmin.homepage'))->with('success', 'Rumah Sakit berhasil ditambahkan.');
    }

    public function editData(RumahSakit $rumahSakit){
        return view('superadmin.edit', compact('rumahSakit'));
    }

    public function updateDataRS(Request $request, $id){
        $admin = Admin::where('rumah_sakit_id', $id)->firstOrFail();
        $rumahSakit = $admin->rumahSakit;
        $userAdmin = $admin->user;

        $request->validate([
            'nama_rs' => 'nullable|string|max:100',
            'alamat' => 'nullable|string|max:100',
            'noTelepon' => 'nullable|string|max:10',

            'nama_admin' => 'nullable|string|max:100',
            'email' => 'nullable|email|unique:users,email,'.$userAdmin->$id,
            'password' => 'nullable|confirmed|min:8'
        ]);

        $rumahSakit->update([
            'nama' => $request->nama_rs ?? $rumahSakit->nama,
            'alamat' => $request->alamat ?? $rumahSakit->alamat,
            'noTelepon' => $request->noTelepon ?? $rumahSakit->noTelepon
        ]);

        $userAdmin->update([
            'name' => $request->nama_admin ?? $userAdmin->name,
            'email' => $request->email ?? $userAdmin->email,
            'password' => $request->password ? Hash::make($request->password) : $userAdmin->password
        ]);

        return redirect(route('superadmin.homepage'))->with('success', 'Data berhasil diupdate');
    }

    public function deleteData(RumahSakit $rumahSakit){
        $rumahSakit->delete();
        return redirect(route('superadmin.homepage'))->with('success', 'Data berhasil dihapus');
    }
}
