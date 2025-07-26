<?php

namespace App\Http\Controllers;

use App\Models\MasterPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function showLoginForm()
    {
        return view('authentication.login');
    }
    
    public function login(Request $request){
        $request->validate([
            'email'=> 'required|email', 
            'password'=> 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email'=> ' Email tidak terdaftar.'
            ])->withInput();
        }
        
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.'
            ])->withInput();
        }

        Auth::login($user);
        $role = $user->role;

        return match ($role) {
            'superadmin' => redirect('/superadmin/homepage'),
            'admin' => redirect('/admin/homepage'),
            'petugas' => redirect('/petugas/homepage'),
            'dokter' => redirect('/dokter/homepage'),
            'pasien' => redirect('/pasien/homepage'),
            default => redirect('/')
        };
    }

    public function showRegisterForm(){
        return view('authentication.register');
    }

    public function registerPasien(Request $request){

        if (User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email sudah terdaftar.'])->withInput();
        }

        $request->validate([
            'name' => 'required|string|max:100',
            'noHP' => ['required', 'regex:/^08[0-9]{8,11}$/'],
            'password' => 'required|confirmed|min:8'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'noHP' => $request->noHP,
            'role' => 'pasien',
            'status' => 'aktif'
        ]);

        MasterPasien::create([
            'user_id'=> $user->id
        ]);

        $user->sendEmailVerificationNotification();
        Auth::login($user);
        return redirect('/pasien/homepage')->with('success', 'Pendaftaran berhasil!');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
