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
            'password' => 'required|confirmed|min:8'
        ]);

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
            // Petugas ga pernah minta no hp tapi di databaseny masih ad no hp, kasih default biar ga error, nanti di databasenya hapus kalo ga kepake
            'noHP' => '08123456789',
        ]);

        // dikomen dulu soalnya belum perlu, cuma mau tes bikin akunnya bisa atau engga, ga perlu beneran kirim email ke gmailnya
        // $user->sendEmailVerificationNotification();
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
