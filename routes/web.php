<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DicomController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JenisPemeriksaanController;
use App\Http\Controllers\ModalitasController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SuperAdminController;
use App\Models\JenisPemeriksaan;
use App\Models\RumahSakit;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('authentication/login');
});

//Verification
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


//Homepage per Role
// Route::get('/superadmin/homepage', function(){
//     return view('superadmin.homepage');
// })->middleware('auth', 'verified', 'role:superadmin');

Route::middleware(['auth', 'verified', 'role:superadmin'])->prefix('superadmin')->group(function () {
    // Route::get('/homepage', [RumahSakitController::class, 'countRS'])->name('superadmin.homepage');
    Route::get('/homepage', [RumahSakitController::class, 'tampilkanRumahSakit'])->name('superadmin.homepage');
    Route::get('/addnew', [RumahSakitController::class, 'addNew'])->name('superadmin.addnew');
    Route::post('/addnew', [RumahSakitController::class, 'store'])->name('superadmin.submit');
    Route::get('/{rumahSakit}/edit', [RumahSakitController::class, 'editData'])->name('superadmin.edit');
    Route::put('/{id}/edit', [RumahSakitController::class, 'updateDataRS'])->name('superadmin.submitdata');
    Route::delete('{rumahSakit}/delete', [RumahSakitController::class, 'deleteData'])->name('superadmin.delete');

    // Route::get('/addnew', function () {
    //     return view('superadmin.addnew');
    // })->name('superadmin.addnew');

    // Route::get('/edit', function() {
    //     return view('superadmin.edit');
    // })->name('superadmin.addnew');
});

// Route::get('/admin/homepage', function(){
//     $admin = auth()->user()->admin;
//     return view('admin.homepage', compact('admin'));
// })->middleware('auth', 'verified', 'role:admin');

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

Route::middleware(['auth', 'verified', 'role:petugas'])->prefix('petugas')->group(function () {
    Route::get('/homepage', function(){
        return view('petugas.homepage');
    })->name('petugas.homepage');

    Route::get('/kelolajenispemeriksaan', [JenisPemeriksaanController::class, 'tampilkanJenisPemeriksaan'])->name('petugas.kelolajenispemeriksaan');
    Route::get('/kelolamodalitas', [ModalitasController::class, 'tampilkanModalitas'])->name('petugas.kelolamodalitas');

    Route::get('/tambahjenispemeriksaanpage', function () {
        return view('petugas.tambahjenispemeriksaanpage');
    })->name('petugas.tambahjenispemeriksaanpage');

    Route::get('/tambahmodalitaspage', function () {
        return view('petugas.tambahmodalitaspage');
    })->name('petugas.tambahmodalitaspage');

    Route::post('/tambahJenisPemeriksaan', [JenisPemeriksaanController::class, 'tambahJenisPemeriksaan'])->name('petugas.tambahJenisPemeriksaan');
    Route::put('/editJenisPemeriksaan/{id}', [JenisPemeriksaanController::class, 'editJenisPemeriksaan'])->name('petugas.editJenisPemeriksaan');
    Route::delete('/hapusJenisPemeriksaan/{id}', [JenisPemeriksaanController::class, 'hapusJenisPemeriksaan'])->name('petugas.hapusJenisPemeriksaan');

    Route::post('/tambahModalitas', [ModalitasController::class, 'tambahModalitas'])->name('petugas.tambahModalitas');
    Route::put('/editModalitas/{id}', [ModalitasController::class, 'editModalitas'])->name('petugas.editModalitas');
    Route::delete('/hapusModalitas/{id}', [ModalitasController::class, 'hapusModalitas'])->name('petugas.hapusModalitas');
});

Route::get('/dokter/homepage', function(){
    return view('dokter.homepage');
})->middleware('auth', 'verified', 'role:dokter');

Route::middleware(['auth', 'verified', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/homepage', function () {
        return view('pasien.homepage');
    });

    Route::get('/pendaftaran', function () {
        return view('pasien.pendaftaran');
    })->name('pasien.pendaftaran');
});

Route::middleware(['auth', 'verified', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/homepage', [PasienController::class, 'homepage'])->name('pasien.homepage');

    Route::get('/pendaftaran', function(){
        return view('pasien.pendaftaran');
    })->name('pasien.pendaftaran');

});
