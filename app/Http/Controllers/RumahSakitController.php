<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;
use App\Models\Admin;
use App\Models\User;
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
        $admin->rumahSakit->updateJu-mlahPasien($request->jumlahPasien);
        return redirect(route('admin.kelolajadwalpage'));
    }

    public function countRS(){
        $rumahSakit = RumahSakit::where('super_admin_id', auth()->id())->get();
        return view('superadmin.homepage', [
            'rumahSakit' => $rumahSakit
        ]);
    }

    public function addNew(){
        return view('superadmin.addnew');
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
            'noTelepon' => $request->noTelepon,
            'jamBuka' => '08:00',
            'jamTutup' => '17:00',
            'jumlahPasien' => 5,
            'super_admin_id' => auth()->id()
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

    public function homepage(){
        $rumahSakit = RumahSakit::where('super_admin_id', auth()->id())->get();
        return redirect(route('superadmin.homepage'));
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
            'email' => 'nullable|email|unique:users,email,'.$userAdmin->id,
            'password' => 'nullable|confirmed|min:8'
        ],
        [
            'password.confirmed' => 'The password does not match, try again.'
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

        return redirect('/superadmin/homepage')->with('success', 'Data berhasil diupdate');
    }

    public function deleteData(RumahSakit $rumahSakit){
        $rumahSakit->admin->user->delete();
        $rumahSakit->delete();
        return redirect()->route('superadmin.homepage')->with('success', 'Data berhasil dihapus');
    }

    public function tampilkanRumahSakit(Request $request)
    {
        $userAdmin = auth()->user()->superadmin;

        $rumahSakits = $userAdmin->rumahSakit()
            ->when($request->search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%")
                ->orWhere('alamat', 'like', "%{$search}%")
                ->orWhere('noTelepon', 'like', "%{$search}%");
            })
            ->get();

        $totalRS = $userAdmin->rumahSakit()->count();

        return view('superadmin.homepage', compact('rumahSakits', 'totalRS'));

    }
}
