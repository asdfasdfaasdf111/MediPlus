<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DataPemeriksaanController;
use App\Http\Controllers\DataPasienController;
use App\Http\Controllers\DicomController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JenisPemeriksaanController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\ModalitasController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SuperAdminController;
use App\Models\DataPemeriksaan;
use App\Models\JenisPemeriksaan;
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
    // Route::get('/homepage', [RumahSakitController::class, 'countRS'])->name('superadmin.homepage');
    Route::get('/homepage', [RumahSakitController::class, 'tampilkanRumahSakit'])->name('superadmin.homepage');
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

    Route::get('/kelolajadwalpage', [RumahSakitController::class, 'index'])
        ->name('admin.kelolajadwalpage');
    Route::post('/kelolajadwalpage/update', [RumahSakitController::class, 'updateJadwal'])
        ->name('admin.updateJadwal');

    

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

    Route::get('/detailpemeriksaan/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('petugas.detailpemeriksaan', compact('dataPemeriksaan'));
    })->name('petugas.detailpemeriksaan');

    Route::get('/pratinjaupemeriksaan/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('petugas.pratinjaupemeriksaan', compact('dataPemeriksaan'));
    })->name('petugas.pratinjaupemeriksaan');

    Route::get('/editpendaftaran/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('petugas.editpendaftaran', compact('dataPemeriksaan'));
    })->name('petugas.editpendaftaran');

    Route::put('/updatePendaftaran/{dataPemeriksaan}', [DataPemeriksaanController::class, 'updatePendaftaran'])->name('petugas.updatePendaftaran');

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

//buat route yg bisa diakses lebih dari 1 role, asalkan memenuhi kondisi tertentu
Route::middleware(['auth', 'verified'])->group(function () {
    Route::put('/updateJadwal/{dataPemeriksaan}/{draft}', [DataPemeriksaanController::class, 'updateJadwal'])->name('updateJadwal');
});

Route::middleware(['auth', 'verified', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/homepage', [PasienController::class, 'homepage'])->name('pasien.homepage');

    // Pilih jadwal
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pasien.pendaftaran');
    
    // Halaman pilih tipe pasien
    Route::get('/pendaftaran/tipepasien', [PendaftaranController::class, 'tipePasien'])
        ->name('pasien.pendaftaran.tipepasien');

    Route::get('/daftarpilihjadwal', function () {
        return view('pasien.daftarpilihjadwal');
    })->name('pasien.daftarpilihjadwal');

    Route::get('/daftartipepasien', function () {
        return view('pasien.daftartipepasien');
    })->name('pasien.daftartipepasien');

    Route::get('/daftardatarujukan', function () {
        return view('pasien.daftardatarujukan');
    })->name('pasien.daftardatarujukan');

    // Form tambah & simpan Data Pasien
    Route::get('/pendaftaran/datapasien/create', [PendaftaranController::class, 'createDataPasien'])
        ->name('pasien.datapasien.create');
    Route::post('/pendaftaran/datapasien', [PendaftaranController::class, 'storeDataPasien'])
        ->name('pasien.datapasien.store');

    // Edit & Update
    Route::get('/pendaftaran/datapasien/{pasien}/edit', [PendaftaranController::class, 'editDataPasien'])
        ->name('pasien.datapasien.edit');
    Route::put('/pendaftaran/datapasien/{pasien}', [PendaftaranController::class, 'updateDataPasien'])
        ->name('pasien.datapasien.update');

    // Hapus
    Route::delete('/pendaftaran/datapasien/{pasien}', [PendaftaranController::class, 'destroyDataPasien'])
        ->name('pasien.datapasien.destroy');

    //FaQ page
    Route::view('/faq', 'pasien.faq')->name('pasien.faq');
    Route::view('/tentangkami', 'pasien.tentangkami')->name('pasien.tentangkami');

    Route::post('/bikindraft', [DataPemeriksaanController::class, 'bikinDraft'])->name('pasien.bikinDraft');

    Route::put('/updateTipePasien/{dataPemeriksaan}', [DataPemeriksaanController::class, 'updateTipePasien'])->name('pasien.updateTipePasien');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});

Route::post('/kritik-saran', [KritikSaranController::class, 'store'])->name('kritik.saran');

Route::get('/api/jenisPemeriksaanSpesifik/{rumahSakit}/{jenis}', 
            function ($rumahSakitId, $jenis) { $rumahSakit = RumahSakit::find($rumahSakitId); 
            return $rumahSakit->jenisPemeriksaanSpesifik($jenis)->get(); });

Route::get('/api/jadwalPenuh/{rumahSakit}/{jenis}', 
            function ($rumahSakitId, $jenisId) { 
                $rumahSakit = RumahSakit::find($rumahSakitId); 
                $jenisPemeriksaan = JenisPemeriksaan::find($jenisId);
                return $rumahSakit->jadwalPenuh($jenisPemeriksaan); });

Route::get('/api/jamTersedia/{rumahSakit}/{jenis}/{tanggal}/{dataPemeriksaan?}', 
            function ($rumahSakitId, $jenisId, $tanggal, $dataPemeriksaanId = null) { 
                $rumahSakit = RumahSakit::find($rumahSakitId); 
                $jenisPemeriksaan = JenisPemeriksaan::find($jenisId);
                $dataPemeriksaan = DataPemeriksaan::find($dataPemeriksaanId);
                return $rumahSakit->jamTersedia($jenisPemeriksaan, $tanggal, $dataPemeriksaan); });

Route::get('/api/namaJenisPemeriksaan/{rumahSakit}', 
            function ($rumahSakitId) { 
                $rumahSakit = RumahSakit::find($rumahSakitId); 
                return $rumahSakit->namaJenisPemeriksaan(); });