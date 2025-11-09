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
        //1. Validasi input
        $request->validate([
            'email'=> 'required|email', 
            'password'=> 'required'
        ]);

        //2. Cari user by email
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

        //3. Izin tambahin, mau cek verifikasi
         if (method_exists($user, 'hasVerifiedEmail') && !$user->hasVerifiedEmail()) {

        $user->sendEmailVerificationNotification();

        return back()
            ->withErrors([
                'email_not_verified' => 'Akun Anda belum terverifikasi. Kami telah mengirim ulang link verifikasi ke email Anda.'
            ])
            ->withInput();
        }

        Auth::login($user, $request->boolean('remember')); //izin tambahin kata gpt buat yang remember hehe

        return match ($user->role) {
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

        //izin ubah biar ada alert user cek email verifikasi
        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silahkan cek email Anda untuk verifikasi akun.');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
