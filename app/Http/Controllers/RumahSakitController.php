<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RumahSakit;
use App\Models\Admin;
use App\Models\JadwalRumahSakit;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RumahSakitController extends Controller
{
    public function updateJadwal(Request $request){
        $request->validate([
            'jadwal.*.jamBukaJam' => 'required|between:0,23',
            'jadwal.*.jamTutupJam' => 'required|between:0,23',
            'jadwal.*.jamBukaMenit' => 'required|between:0,59',
            'jadwal.*.jamTutupMenit' => 'required|between:0,59',
        ]);

        $jadwalArray = [];

        foreach ($request->input('jadwal', []) as $index => $jadwal) {
            $jamBuka  = sprintf("%02d:%02d", $jadwal['jamBukaJam'], $jadwal['jamBukaMenit']);
            $jamTutup = sprintf("%02d:%02d", $jadwal['jamTutupJam'], $jadwal['jamTutupMenit']);
            
            if ($jamTutup <= $jamBuka){
                return back()->withErrors(['jadwal'.($index+1).'jamBuka' => 'Jam tutup harus lebih besar dari jam buka']);
            }
            $jadwalArray[$index] = [
                'jamBuka'  => $jamBuka,
                'jamTutup' => $jamTutup,
                'buka' => $jadwal['buka'],
            ];
        }
        $admin = auth()->user()->admin;
        $admin->rumahSakit->updateJadwal($jadwalArray);
        return redirect(route('admin.kelolajadwalpage'))->with('success', 'Jadwal operasional berhasil diperbarui');
    }

    public function index()
{
    $admin = auth()->user()->admin;
    $rs    = $admin->rumahSakit;

    // pastikan ada 7 baris (Senin–Minggu)
    DB::transaction(function () use ($rs) {
        for ($i = 1; $i <= 7; $i++) {
            JadwalRumahSakit::firstOrCreate(
                ['rumah_sakit_id' => $rs->id, 'indexJadwal' => $i],
                ['buka' => 0, 'jamBuka' => '08:00:00', 'jamTutup' => '16:00:00']
            );
        }
    });

    $rows = $rs->jadwalRumahSakit()->orderBy('indexJadwal')->get();

    return view('admin.kelolajadwalpage', compact('admin','rows'));
}

    public function updateJumlahPasien(Request $request){
        $request->validate([
            'jumlahPasien' => 'required|numeric|min:1',
        ]);

        $admin = auth()->user()->admin;
        $admin->rumahSakit->updateJumlahPasien($request->jumlahPasien);
        return redirect(route('admin.kelolajadwalpage'))->with('success', 'Kuota pasien berhasil diperbarui');
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
            'nama_rs' => 'required|string|max:100|unique:rumah_sakits,nama',
            'alamat' => 'required',
            'noTelepon' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

            'nama_admin' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8'
        ],
        [
            //Rumah Sakit
            'nama_rs.required' => 'Nama Rumah Sakit wajib diisi.',
            'nama_rs.unique' => 'Nama Rumah Sakit sudah terdaftar.',
            'alamat.required' => 'Alamat Rumah Sakit wajib diisi.',
            'noTelepon.required' => 'Nomor Telepon Rumah Sakit wajib diisi.',

            'foto.image' => 'File foto harus berupa gambar.',
            'foto.mimes' => 'Foto harus berformat jpeg, jpg, atau png.', //format file
            'foto.max'   => 'Ukuran foto maksimal 2MB.',

            //Admin
            'nama_admin.required' => 'Nama Admin wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Password dan konfirmasi password tidak sesuai.',
            'password.min' => 'Password minimal 8 karakter.'

        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto      = $request->file('foto')->store('foto_rumah_sakit', 'public');
        }

        $rumahSakit = RumahSakit::create([
            'nama' => $request->nama_rs,
            'alamat' => $request->alamat,
            'noTelepon' => $request->noTelepon,
            'foto' => $pathFoto,
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
