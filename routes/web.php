<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\PendaftaranController;
use App\Models\RumahSakit;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('authentication/login');
});

//VERIFICATION
//kalo akun yang ga verified coba akses page yang perlu verification, kena redirect kesini
Route::get('/email/verify', function (){
    return redirect('/login');
})->middleware('auth')->name('verification.notice');

//kalo user klik tombol verify di gmail mreka, bakal di redirect kesini
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

//fungsi buat kirim email verification ulang
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link send!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//Login
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthenticationController::class, 'login'])->name('login.submit');

//Registration
Route::get('/register', [AuthenticationController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthenticationController::class, 'registerPasien'])->name('register.submit');

//Logout
Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');



Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/homepage', [RumahSakitController::class, 'countRS'])->name('superadmin.homepage');
    Route::get('/addnew', [RumahSakitController::class, 'addNew'])->name('superadmin.addnew');
    Route::post('/addnew', [RumahSakitController::class, 'store'])->name('superadmin.submit');
    Route::get('/{rumahSakit}/edit', [RumahSakitController::class, 'editData'])->name('superadmin.edit');
    Route::put('/{id}/edit', [RumahSakitController::class, 'updateDataRS'])->name('superadmin.submitdata');
    Route::delete('{rumahSakit}/delete', [RumahSakitController::class, 'deleteData'])->name('superadmin.delete');

});

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/homepage', function () {
        return view('admin.homepage');
    })->name('admin.homepage');

    Route::get('/keloladokterpage', [DokterController::class, 'tampilkanDokter'])->name('admin.keloladokterpage');
    Route::get('/kelolapetugaspage', [PetugasController::class, 'tampilkanPetugas'])->name('admin.kelolapetugaspage');

    Route::get('/kelolajadwalpage', function () {
        return view('admin.kelolajadwalpage');
    })->name('admin.kelolajadwalpage');

    Route::get('/logaktivitaspage', function () {
        return view('admin.logaktivitaspage');
    })->name('admin.logaktivitaspage');

    Route::get('/tambahakundokterpage', function () {
        return view('admin.tambahakundokterpage');
    })->name('admin.tambahakundokterpage');

    Route::get('/tambahakunpetugaspage', function () {
        return view('admin.tambahakunpetugaspage');
    })->name('admin.tambahakunpetugaspage');

    

    Route::post('/updateJadwal', [RumahSakitController::class, 'updateJadwal'])->name('admin.updateJadwal');
    Route::post('/updateJumlahPasien', [RumahSakitController::class, 'updateJumlahPasien'])->name('admin.updateJumlahPasien');
    Route::post('/tambahAkunDokter', [DokterController::class, 'tambahAkunDokter'])->name('admin.tambahAkunDokter');
    Route::post('/tambahAkunPetugas', [PetugasController::class, 'tambahAkunPetugas'])->name('admin.tambahAkunPetugas');
    Route::delete('/hapusAkunPetugas/{id}', [PetugasController::class, 'hapusAkunPetugas'])->name('admin.hapusAkunPetugas');
    Route::delete('/hapusAkunDokter/{id}', [DokterController::class, 'hapusAkunDokter'])->name('admin.hapusAkunDokter');

});

Route::get('/petugas/homepage', function(){
    return view('petugas.homepage');
})->middleware('auth', 'verified', 'role:petugas');

Route::get('/dokter/homepage', function(){
    return view('dokter.homepage');
})->middleware('auth', 'verified', 'role:dokter');


Route::middleware(['auth', 'verified', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/homepage', [PasienController::class, 'homepage'])->name('pasien.homepage');

    // 1 : Pilih jadwal
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pasien.pendaftaran');
    Route::post('/pendaftaran', [PendaftaranController::class, 'storeStep1'])->name('pasien.pendaftaran.storeStep1');

    //START 2-5 ITU NANTIAN DULU. KERJA PER PAGE
    // 2 : Tipe Pasien
    Route::get('/pendaftaran/tipepasien', function(){
        return view('pasien.pendaftaran.tipepasien');
    })->name('pasien.pendaftaran.tipepasien');

    // 3 : Form Data Diri
    Route::get('/pendaftaran/formdatadiri', function(){
        return view('pasien.pendaftaran.formdatadiri');
    })->name('pasien.pendaftaran.formdatadiri');

    // 4 : Data Rujukan
    Route::get('/pendaftaran/datarujukan', function(){
        return view('pasien.pendaftaran.datarujukan');
    })->name('pasien.pendaftaran.datarujukan');

    // 5 : Ringkasan
    Route::get('/pendaftaran/ringkasan', function(){
        return view('pasien.pendaftaran.ringkasan');
    })->name('pasien.pendaftaran.ringkasan');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/kritik-saran', [KritikSaranController::class, 'store'])->name('kritik.saran');
