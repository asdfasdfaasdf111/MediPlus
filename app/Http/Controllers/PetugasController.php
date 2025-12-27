<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function hapusAkunPetugas($id){
        $account = User::findOrFail($id);
        $account->delete();
    
        return redirect()->back()->with('success', 'Account deleted successfully.');
    }

    public function tambahAkunPetugas(Request $request){
        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'foto'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
                'name.required'  => 'Nama lengkap wajib diisi.',
                'name.max' => 'Nama lengkap maksimal 100 karakter.',

                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah terdaftar.',

                'password.required' => 'Password wajib diisi.',
                'password.confirmed'  => 'Password dan konfirmasi password tidak sesuai.',
                'password.min'  => 'Password minimal 8 karakter.',

                'foto.image'   => 'File foto harus berupa gambar.',
                'foto.mimes'  => 'Foto harus berformat jpeg, jpg, png, gif, atau svg.',
                'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        $pathFoto = null;
        if ($request->hasFile('foto')) {
            $pathFoto = $request->file('foto')->store('foto_petugas', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas',
            'status' => 'aktif'
        ]);

        $admin = auth()->user()->admin;

        Petugas::create([
            'user_id'=> $user->id,
            'admin_id' => $admin->id,
            'rumah_sakit_id' => $admin->rumahSakit->id,
            'noHP' => '08123456789',
            'foto' => $pathFoto,
        ]);

        return redirect()->route('admin.kelolapetugaspage')->with('success', 'Akun petugas berhasil dibuat!');
    }

    public function tampilkanPetugas(Request $request)
    {
        $admin = auth()->user()->admin;
        $rumahSakit = $admin->rumahSakit;

        $petugass = $rumahSakit->petugas()
            ->when($request->search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->get();

            

        return view('admin.kelolapetugaspage', compact('petugass'));
    }
}
