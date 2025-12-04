<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DataPemeriksaanController;
use App\Http\Controllers\DataPasienController;
use App\Http\Controllers\DataRujukanController;
use App\Http\Controllers\DicomController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DraftLaporanController;
use App\Http\Controllers\JenisPemeriksaanController;
use App\Http\Controllers\KritikSaranController;
use App\Http\Controllers\ModalitasController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RumahSakitController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\DashboardPetugasController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HasilPemeriksaanController;
use App\Models\DataPemeriksaan;
use App\Models\JenisPemeriksaan;
use App\Models\RumahSakit;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


Route::get('/', function () {
    return view('authentication/login');
});

//VERIFICATION
//kalo akun yang ga verified coba akses page yang perlu verification, kena redirect kesini
Route::get('/email/verify', function (){
    return redirect('/login');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (Request $request, $id, $hash) {
    $user = User::findOrFail($id);

    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Link verifikasi tidak valid.');
    }

    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
        event(new Verified($user));
    }

    return redirect()
        ->route('login')
        ->with('success', 'Email Anda berhasil diverifikasi. Silahkan login.');
})->middleware('signed')->name('verification.verify');


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

//Forgot Password dari Library Laravel -> buat view isi email
Route::get('/forgotpassword', function () {
    return view('authentication.forgotpassword');
})->middleware('guest')->name('password.request');


//Form Submission Forgot Password
Route::post('/forgotpassword', function (HttpRequest $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', 'Link reset password telah dikirim ke email Anda.')
        : back()->withErrors(['email' => 'Email tidak terdaftar atau gagal mengirim link.']);
})->middleware('guest')->name('password.email');

//Form Reset Password
Route::get('/resetpassword/{token}', function (HttpRequest $request, $token) {
    return view('authentication.resetpassword', [
        'token' => $token,
        'email' => $request->query('email'),
    ]);
})->middleware('guest')->name('password.reset');

Route::post('/resetpassword', function (HttpRequest $request) {
    $request->validate([
        'token'    => ['required'],
        'email'    => ['required', 'email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', 'Password berhasil direset. Silahkan login kembali.')
        : back()->withErrors(['email' => 'Token tidak valid atau email tidak sesuai.']);
    })->middleware('guest')->name('password.update');



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
    Route::get('/homepage', [DashboardPetugasController::class, 'tampilkanDashboard'])->name('petugas.dashboard');
    

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

    Route::get('/api/jenisPemeriksaanSpesifik/{rumahSakit}/{jenis}',
                function ($rumahSakitId, $jenis) { $rumahSakit = RumahSakit::find($rumahSakitId);
                return $rumahSakit->jenisPemeriksaanSpesifik($jenis)->get(); });

    Route::get('/api/jadwalPenuh/{rumahSakit}/{jenis}',
                function ($rumahSakitId, $jenisId) {
                    $rumahSakit = RumahSakit::find($rumahSakitId);
                    $jenisPemeriksaan = JenisPemeriksaan::find($jenisId);
                    return $rumahSakit->jadwalPenuh($jenisPemeriksaan); });

    Route::get('/api/jamTersedia/{rumahSakit}/{jenis}/{tanggal}/{dataPemeriksaan}',
                function ($rumahSakitId, $jenisId, $tanggal, $dataPemeriksaanId) {
                    $rumahSakit = RumahSakit::find($rumahSakitId);
                    $jenisPemeriksaan = JenisPemeriksaan::find($jenisId);
                    $dataPemeriksaan = DataPemeriksaan::find($dataPemeriksaanId);
                    return $rumahSakit->jamTersedia($jenisPemeriksaan, $tanggal, $dataPemeriksaan); });

    Route::get('/listantrian', function () {
        return view('petugas.listantrian');
    })->name('petugas.listantrian');
});

// Route::get('/dokter/homepage', function(){
//     return view('dokter.homepage');
// })->middleware('auth', 'verified', 'role:dokter');

//buat route yg bisa diakses lebih dari 1 role, asalkan memenuhi kondisi tertentu //Punya Leo
Route::middleware(['auth', 'verified'])->group(function () {
    Route::put('/updateJadwal/{dataPemeriksaan}/{draft}', [DataPemeriksaanController::class, 'updateJadwal'])->name('updateJadwal');
});

Route::middleware(['auth', 'verified', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/homepage', function(){
        return view('dokter.homepage');
    })->name('dokter.homepage');

    Route::get('/detailpemeriksaan/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('dokter.detailpemeriksaan', compact('dataPemeriksaan'));
    })->name('dokter.detailpemeriksaan');

    Route::get('/listdraft', [DraftLaporanController::class, 'index'])->name('dokter.listdaftar');
    Route::get('/addnew', [DraftLaporanController::class, 'addNew'])->name('dokter.addnew');
    Route::post('/addnew', [DraftLaporanController::class, 'store'])->name('dokter.submit');
    Route::get('/{draft}/edit', [DraftLaporanController::class, 'editData'])->name('dokter.edit');
    Route::put('/{id}/edit', [DraftLaporanController::class, 'updateDraft'])->name('dokter.submitdata');
    Route::delete('{draft}/delete', [DraftLaporanController::class, 'deleteData'])->name('dokter.delete');

    Route::post('/uploadLaporan/{dataPemeriksaan}', [HasilPemeriksaanController::class, 'bikinHasilPemeriksaan'])->name('dokter.uploadLaporan');

    Route::get('/file-upload/{dataPemeriksaan}', [FileController::class, 'index'])->name('dokter.index');
    Route::post('file-upload/{dataPemeriksaan}', [FileController::class, 'store'])->name('dokter.hasilpemeriksaan');
});

Route::middleware(['auth', 'verified', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/homepage', [PasienController::class, 'homepage'])->name('pasien.homepage');

    // Pilih jadwal
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pasien.pendaftaran');

    // Halaman pilih tipe pasien
    Route::get('/pendaftaran/tipepasien', [PendaftaranController::class, 'tipePasien'])
        ->name('pasien.pendaftaran.tipepasien');
    
    //Nyesuain sama folder viewnya
    Route::get('/daftarpilihjadwal', function () {
        return view('pasien.formdaftarpemeriksaan.daftarpilihjadwal');
    })->name('pasien.daftarpilihjadwal');

    Route::get('/daftartipepasien', function () {
        return view('pasien.formdaftarpemeriksaan.daftartipepasien');
    })->name('pasien.daftartipepasien');

    Route::get('/daftardatarujukan', function () {
        return view('pasien.formdaftarpemeriksaan.daftardatarujukan');
    })->name('pasien.daftardatarujukan');

    Route::get('/daftarringkasan', function () {
        return view('pasien.formdaftarpemeriksaan.daftarringkasan');
    })->name('pasien.daftarringkasan');

    Route::get('/editpendaftaran/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('pasien.formdaftarpemeriksaan.editpendaftaran', compact('dataPemeriksaan'));
    })->name('pasien.editpendaftaran');

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
    Route::put('/hapusPendaftaran/{dataPemeriksaan}', [DataPemeriksaanController::class, 'hapusPendaftaran'])
        ->name('pasien.hapusPendaftaran');

    //FaQ page
    Route::view('/faq', 'pasien.faq')->name('pasien.faq');
    Route::view('/tentangkami', 'pasien.tentangkami')->name('pasien.tentangkami');
    Route::post('/bikindraft', [DataPemeriksaanController::class, 'bikinDraft'])->name('pasien.bikinDraft');
    Route::post('/bikinDataRujukan/{dataPemeriksaan}', [DataRujukanController::class, 'bikinDataRujukan'])->name('pasien.bikinDataRujukan');
    Route::put('/updateTipePasien/{dataPemeriksaan}', [DataPemeriksaanController::class, 'updateTipePasien'])->name('pasien.updateTipePasien');
    Route::put('/updateTanggal/{dataPemeriksaan}', [DataPemeriksaanController::class, 'updateTanggal'])->name('pasien.updateTanggal');
    Route::put('/updateDataRujukan/{dataPemeriksaan}/{dataRujukan}', [DataRujukanController::class, 'updateDataRujukan'])->name('pasien.updateDataRujukan');
    Route::put('/finalisasiDraft/{dataPemeriksaan}', [DataPemeriksaanController::class, 'finalisasiDraft'])->name('pasien.finalisasiDraft');
    Route::get('/detailpemeriksaan/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('pasien.detailpemeriksaan', compact('dataPemeriksaan'));
    })->name('pasien.detailpemeriksaan');
        Route::get('/hasilpemeriksaan/{dataPemeriksaan}', function (DataPemeriksaan $dataPemeriksaan) {
        return view('pasien.hasilpemeriksaan', compact('dataPemeriksaan'));
    })->name('pasien.hasilpemeriksaan');
    Route::put('/selesaiPemeriksaan/{dataPemeriksaan}', [DataPemeriksaanController::class, 'selesaiPemeriksaan'])->name('pasien.selesaiPemeriksaan');

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
Route::get('/api/namaJenisPemeriksaan/{rumahSakit}', function ($rumahSakitId) {
                $rumahSakit = RumahSakit::find($rumahSakitId);
                return $rumahSakit->namaJenisPemeriksaan(); 
});
