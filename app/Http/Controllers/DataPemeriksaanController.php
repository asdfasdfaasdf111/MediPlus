<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CounterAntrian;
use App\Models\DataPasien;
use App\Models\DataPemeriksaan;
use App\Models\Dokter;
use App\Models\MasterPasien;
use App\Models\RumahSakit;
use App\Models\User;
use App\Notifications\PendaftaranDiterima;
use App\Services\LogService;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

class DataPemeriksaanController extends Controller
{
    public function updatePendaftaran(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'dokterId' => 'required|exists:dokters,id',
        ]);
        $petugas = auth()->user()->petugas;
        if ($petugas && !$request->filled('catatanPetugas') && $request->status == 'rejected') {
            return back()->withErrors([
                'catatanPetugas' => 'Catatan petugas wajib diisi ketika menolak pendaftaran.',
            ])->withInput();
        }
        $dokter = Dokter::findOrFail($request->dokterId);
        $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
        if ($request->status == 'accepted' && !$dokter->available($dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan->rentangWaktuKedatangan, $jenisPemeriksaan->lamaPemeriksaan, $jenisPemeriksaan)) {
            return back()->withErrors([
                'dokter_id' => 'Dokter ini tidak tersedia pada jadwal tersebut',
            ]);
        }

        $adaPerubahanJenis = $dataPemeriksaan->historyJenisPemeriksaan !== null 
                     && $dataPemeriksaan->jenis_pemeriksaan_id != $dataPemeriksaan->historyJenisPemeriksaan;
        $adaPerubahanTanggal = $dataPemeriksaan->historyTanggalPemeriksaan !== null 
                     && $dataPemeriksaan->tanggalPemeriksaan != $dataPemeriksaan->historyTanggalPemeriksaan;
        $adaPerubahanJam = $dataPemeriksaan->historyJamPemeriksaan !== null 
                     && $dataPemeriksaan->rentangWaktuKedatangan != $dataPemeriksaan->historyJamPemeriksaan;

        $adaPerubahan = $adaPerubahanJenis || $adaPerubahanTanggal || $adaPerubahanJam;

        // CUMA PETUGAS yang boleh mengubah catatanPetugas
        if ($petugas && $adaPerubahan && !$request->filled('catatanPetugas')) {
            return back()->withErrors([
                'catatanPetugas' => 'Catatan petugas wajib diisi ketika mengubah detail pemeriksaan.',
            ])->withInput();
        }

        if ($request->filled('catatanPetugas')) {
            $dataPemeriksaan->catatanPetugas = $request->catatanPetugas;
        }

        if ($request->status == 'accepted'){
            $dataPemeriksaan->statusPasien = "Menunggu Pembayaran";
            $dataPemeriksaan->statusPetugas = "Menunggu Pembayaran";
            $dataPemeriksaan->statusDokter = "Menunggu Pembayaran";
            $dataPemeriksaan->dokter_id = $request->dokterId;
            $userPasien = $dataPemeriksaan->masterPasien->user;
            $userPasien->notify(new PendaftaranDiterima($dataPemeriksaan));
            LogService::create('Menerima pendaftaran dengan id: '.$dataPemeriksaan->id, $petugas->id);
        }
        else{
            $dataPemeriksaan->statusUtama = "Dibatalkan";
            $dataPemeriksaan->statusPasien = "Pendaftaran Ditolak";
            $dataPemeriksaan->statusPetugas = "Pendaftaran Ditolak";
            $dataPemeriksaan->statusDokter = "Pendaftaran Ditolak";
            $dataPemeriksaan->cancelled_at = now();
            LogService::create('Menolak pendaftaran dengan id: '.$dataPemeriksaan->id, $petugas->id);
        }
        $dataPemeriksaan->save();
        return redirect()->route('petugas.homepage');
    }

    public function updateJadwal(Request $request, DataPemeriksaan $dataPemeriksaan, $draft){
        $isDraft = ($draft == "1" || $draft == "true");
        
        $validated =  $request->validate([
            'kelompokJenisPemeriksaan' => 'required|string',
            'jenisPemeriksaan' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);

        $user = auth()->user();

        if ($user->role === "pasien") {
            if ($dataPemeriksaan->masterPasien->user->id !== $user->id) {
                return back()->withErrors([
                    'salahData' => 'Anda tidak bisa mengubah data pemeriksaan ini',
                ]);
            }
        } elseif ($user->role !== "superadmin") {
            $rumahSakitId =
                optional($user->admin)->rumah_sakit_id
                ?? optional($user->petugas)->rumah_sakit_id
                ?? optional($user->dokter)->rumah_sakit_id;

            if ($dataPemeriksaan->rumah_sakit_id !== $rumahSakitId) {
                return back()->withErrors([
                    'salahData' => 'Anda tidak bisa mengubah data pemeriksaan ini',
                ]);
            }
        }

        $rumahSakit = $dataPemeriksaan->rumahSakit;

        $jenisPemeriksaanBaru = $rumahSakit->jenisPemeriksaan()
            ->where('id', $validated['jenisPemeriksaan'])
            ->first();
        if (!$jenisPemeriksaanBaru) {
            return back()->withErrors([
                'jenisPemeriksaan' => 'Jenis Pemeriksaan tidak ditemukan',
            ])->withInput();
        }

        // $listJam = $rumahSakit->jamTersedia( $jenisPemeriksaanBaru, $validated['tanggalPemeriksaan'], $dataPemeriksaan );
        $result = $rumahSakit->jamTersedia($jenisPemeriksaanBaru, $validated['tanggalPemeriksaan'], $dataPemeriksaan);
        if ($user->petugas) {
            $result = $rumahSakit->jamTersediaPetugas(
                $jenisPemeriksaanBaru,
                $validated['tanggalPemeriksaan'],
                $dataPemeriksaan
            );
        }
        $listJam = $result['listJam'] ?? [];
        $timeAvailable = in_array($validated['rentangWaktuKedatangan'], $listJam);

        if (!$timeAvailable) {
            return back()->withErrors([
                'waktu' => 'Jadwal ini tidak tersedia!',
            ])->withInput();
        }

        $adaPerubahanJenis  = ($dataPemeriksaan->jenis_pemeriksaan_id != $jenisPemeriksaanBaru->id);
        $adaPerubahanTanggal = ($dataPemeriksaan->tanggalPemeriksaan != $validated['tanggalPemeriksaan']);
        $adaPerubahanJam  = ($dataPemeriksaan->rentangWaktuKedatangan != $validated['rentangWaktuKedatangan']);

        $adaPerubahan = $adaPerubahanJenis || $adaPerubahanTanggal || $adaPerubahanJam;

        // Buat nyimpan history kalo ada perubahan dan bukan draft
        if ($user->petugas && !$isDraft && $adaPerubahan && empty($dataPemeriksaan->historyJenisPemeriksaan)) {
            $dataPemeriksaan->historyJenisPemeriksaan = $dataPemeriksaan->jenis_pemeriksaan_id;
            $dataPemeriksaan->historyTanggalPemeriksaan = $dataPemeriksaan->tanggalPemeriksaan;
            $dataPemeriksaan->historyJamPemeriksaan = $dataPemeriksaan->rentangWaktuKedatangan;

            LogService::create(
                'Mengubah pendaftaran dengan id: ' . $dataPemeriksaan->id, $user->petugas->id
            );
        }

        // UPDATE JADWAL
        $dataPemeriksaan->jenis_pemeriksaan_id = $jenisPemeriksaanBaru->id;
        $dataPemeriksaan->tanggalPemeriksaan = $validated['tanggalPemeriksaan'];
        $dataPemeriksaan->rentangWaktuKedatangan = $validated['rentangWaktuKedatangan'];
        $dataPemeriksaan->save();

        if (!$isDraft && $user->petugas) {
            return redirect()->route('petugas.pratinjaupemeriksaan', $dataPemeriksaan);
        }

        if (!$isDraft) {
            return redirect()->route('pasien.pendaftaran');
        }

        return redirect()->route('pasien.daftartipepasien');

    }

    public function updateJadwalOnsite(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'kelompokJenisPemeriksaan' => 'required|string',
            'jenisPemeriksaan' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);

        $rumahSakit = $dataPemeriksaan->rumahSakit;
        $jenisPemeriksaan = $rumahSakit->jenisPemeriksaan()
                                        ->where('id', $request->jenisPemeriksaan)
                                        ->get()
                                        ->first();
        if (!$jenisPemeriksaan){
            return back()->withErrors([
                'jenisPemeriksaan' => 'Jenis Pemeriksaan ini tidak ada',
            ]);
        }

        $result = $rumahSakit->jamTersediaPetugas($jenisPemeriksaan, $request->tanggalPemeriksaan, $dataPemeriksaan);
        $listJam = $result['listJam'] ?? [];
        $timeAvailable = false;
        foreach ($listJam as $jam){
            if ($jam == $request->rentangWaktuKedatangan){
                $timeAvailable = true;
                break;
            }
        }
        if (!$timeAvailable){
            return back()->withErrors([
                'waktu' => 'Jadwal ini tidak tersedia!',
            ]);
        }

        $dataPemeriksaan->jenis_pemeriksaan_id = $jenisPemeriksaan->id;
        $dataPemeriksaan->tanggalPemeriksaan = $request->tanggalPemeriksaan;
        $dataPemeriksaan->rentangWaktuKedatangan = $request->rentangWaktuKedatangan;
        $dataPemeriksaan->save();
        
        return redirect()->route('petugas.daftartipepasien', ['masterPasien' => $dataPemeriksaan->masterPasien->id]);
    }



    public function updateTanggal(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'tanggalPemeriksaan' => 'required|date|after:today',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);
        
        $user = auth()->user();

        //kalo data yg mau diedit bukan punyanya, error
        if ($dataPemeriksaan->masterPasien->user->id !== $user->id) {
            return back()->withErrors([
                'salahData' => 'Anda tidak bisa mengubah data pemeriksaan ini',
            ]);
        }

        $rumahSakit = $dataPemeriksaan->rumahSakit;
        $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;

        $result = $rumahSakit->jamTersedia($jenisPemeriksaan, $request->tanggalPemeriksaan, $dataPemeriksaan);
        $listJam = $result['listJam'] ?? [];
        $timeAvailable = false;
        foreach ($listJam as $jam){
            if ($jam == $request->rentangWaktuKedatangan){
                $timeAvailable = true;
                break;
            }
        }
        if (!$timeAvailable){
            return back()->withErrors([
                'waktu' => 'Jadwal ini tidak tersedia!',
            ]);
        }

        $dataPemeriksaan->tanggalPemeriksaan = $request->tanggalPemeriksaan;
        $dataPemeriksaan->rentangWaktuKedatangan = $request->rentangWaktuKedatangan;
        $dataPemeriksaan->save();
        
        return redirect()->route('pasien.pendaftaran');
    }

    public function bikinDraft(Request $request){
        $request->validate([
            'rumahSakit' => 'required|string',
            'kelompokJenisPemeriksaan' => 'required|string',
            'jenisPemeriksaan' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);

        $rumahSakit = RumahSakit::find($request->rumahSakit);
        $jenisPemeriksaan = $rumahSakit->jenisPemeriksaan()
                                        ->where('id', $request->jenisPemeriksaan)
                                        ->get()
                                        ->first();

        if (!$jenisPemeriksaan){
            return back()->withErrors([
                'jenisPemeriksaan' => 'Jenis Pemeriksaan ini tidak ada',
            ]);
        }
        $user = auth()->user();

        $result = $rumahSakit->jamTersedia($jenisPemeriksaan, $request->tanggalPemeriksaan);
        $listJam = $result['listJam'] ?? [];
        $timeAvailable = false;
        foreach ($listJam as $jam){
            if ($jam == $request->rentangWaktuKedatangan){
                $timeAvailable = true;
                break;
            }
        }
        if (!$timeAvailable){
            return back()->withErrors([
                'waktu' => 'Jadwal ini tidak tersedia!',
            ]);
        }

        DataPemeriksaan::create([
            'jenis_pemeriksaan_id' => $jenisPemeriksaan->id,
            'rumah_sakit_id' => $request->rumahSakit,
            'master_pasien_id' => $user->masterPasien->id,
            'tanggalPemeriksaan' => $request->tanggalPemeriksaan,
            'rentangWaktuKedatangan' => $request->rentangWaktuKedatangan,
            'statusUtama' => 'Draft',
            'statusDokter' => 'Draft Pasien',
            'statusPetugas' => 'Draft Pasien',
            'statusPasien' => 'Draft Pasien',
            'pengingatTerkirim' => false,
        ]);
        
        return redirect()->route('pasien.daftartipepasien');
    }

    public function bikinDraftOnsite(Request $request, $masterPasienId){
        $request->validate([
            'kelompokJenisPemeriksaan' => 'required|string',
            'jenisPemeriksaan' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);

        $rumahSakit = auth()->user()->petugas->rumahSakit;
        $jenisPemeriksaan = $rumahSakit->jenisPemeriksaan()
                                        ->where('id', $request->jenisPemeriksaan)
                                        ->get()
                                        ->first();
        if (!$jenisPemeriksaan){
            return back()->withErrors([
                'jenisPemeriksaan' => 'Jenis Pemeriksaan ini tidak ada',
            ]);
        }

        $masterPasien = MasterPasien::find($masterPasienId);

        DataPemeriksaan::create([
            'jenis_pemeriksaan_id' => $jenisPemeriksaan->id,
            'rumah_sakit_id' => $rumahSakit->id,
            'master_pasien_id' => $masterPasien->id,
            'tanggalPemeriksaan' => $request->tanggalPemeriksaan,
            'rentangWaktuKedatangan' => $request->rentangWaktuKedatangan,
            'statusUtama' => 'Draft',
            'statusDokter' => 'Draft Petugas',
            'statusPetugas' => 'Draft Petugas',
            'statusPasien' => 'Draft Petugas',
            'pengingatTerkirim' => false,
        ]);
        
        return redirect()->route('petugas.daftartipepasien', ['masterPasien' => $masterPasien->id]);
    }

    public function lanjutPendaftaranPasien(){
        $masterPasien = auth()->user()->masterPasien;

        if ($masterPasien->draftPemeriksaan && $masterPasien->draftPemeriksaan->statusPasien !== 'Draft Pasien') {
            $masterPasien->draftPemeriksaan->delete();
        }

        return view('pasien.formdaftarpemeriksaan.daftarpilihjadwal', compact('masterPasien'));
    }

    public function lanjutPendaftaranPetugas($user){
        $masterPasien = User::findOrFail($user)->masterPasien;

        if ($masterPasien->draftPemeriksaan && $masterPasien->draftPemeriksaan->statusPasien !== 'Draft Petugas') {
            $masterPasien->draftPemeriksaan->delete();
        }

        return view('petugas.daftaronsite.daftarpilihjadwal', compact('user'));
    }

    public function updateTipePasien(Request $request, DataPemeriksaan $dataPemeriksaan){
        $masterPasien = auth()->user()->masterPasien;

       $rules = [
            'pilihPasien'      => ['required', 'integer'],
            'pakaiPendamping'  => ['nullable', 'boolean'],
        ];

        if ($request->boolean('pakaiPendamping')) {
            $rules = array_merge($rules, [
                'namaPendamping' => ['required', 'string', 'max:50'],
                'nomorPendamping' => ['required', 'string', 'max:20'],
                'hubunganPendamping' => ['required', 'string'],
            ]);
        }

        $messages = [
            'pilihPasien.required'   => 'Silakan pilih data pasien.',
            'namaPendamping.required'   => 'Nama pendamping wajib diisi.',
            'nomorPendamping.required' => 'Kontak pendamping wajib diisi.',
            'hubunganPendamping.required' => 'Hubungan dengan pasien wajib dipilih.',
        ];
        
        $validated = $request->validate($rules, $messages);

         $dataPasien = $masterPasien->dataPasien()
            ->where('id', $validated['pilihPasien'])
            ->first();

        if (!$dataPasien){
            return back()->withErrors([
                'dataPasien' => 'Data Pasien ini tidak ada',
            ]);
        }

        $dataPemeriksaan->data_pasien_id = $validated['pilihPasien'];

        if ($request->boolean('pakaiPendamping')) {
            $dataPemeriksaan->namaPendamping  = $validated['namaPendamping'];
            $dataPemeriksaan->nomorPendamping = $validated['nomorPendamping'];
            $dataPemeriksaan->hubunganPendamping = $validated['hubunganPendamping'];
        } else {
            $dataPemeriksaan->namaPendamping = null;
            $dataPemeriksaan->nomorPendamping = null;
            $dataPemeriksaan->hubunganPendamping = null;
        }

        $dataPemeriksaan->riwayatAlamatDomisili = $dataPasien->alamatDomisili;
        $dataPemeriksaan->riwayatTanggalLahir = $dataPasien->tanggalLahir;
        $dataPemeriksaan->riwayatJenisKelamin = $dataPasien->jenisKelamin;
        $dataPemeriksaan->riwayatNoHP = $dataPasien->noHP;
        $dataPemeriksaan->riwayatAlergi = $dataPasien->alergi;
        $dataPemeriksaan->riwayatGolonganDarah = $dataPasien->golonganDarah;
        $dataPemeriksaan->save();
        
        return redirect()->route('pasien.daftardatarujukan');
    }

public function updateTipePasienPetugas(Request $request, DataPemeriksaan $dataPemeriksaan)
{
    $masterPasien = $dataPemeriksaan->masterPasien;

    $rules = [
        'pilihPasien' => ['required', 'integer'],
        'pakaiPendamping' => ['nullable', 'boolean'],
    ];

    if ($request->boolean('pakaiPendamping')) {
        $rules = array_merge($rules, [
            'namaPendamping' => ['required', 'string', 'max:50'],
            'nomorPendamping'  => ['required', 'string', 'max:20'],
            'hubunganPendamping' => ['required', 'string'],
        ]);
    }

    $messages = [
        'pilihPasien.required' => 'Silakan pilih data pasien.',
        'namaPendamping.required' => 'Nama pendamping wajib diisi.',
        'nomorPendamping.required' => 'Kontak pendamping wajib diisi.',
        'hubunganPendamping.required' => 'Hubungan dengan pasien wajib dipilih.',
    ];

    $validated = $request->validate($rules, $messages);

    $dataPasien = $masterPasien->dataPasien()
        ->where('id', $validated['pilihPasien'])
        ->first();

    if (!$dataPasien) {
        return back()->withErrors([
            'dataPasien' => 'Data pasien tidak ditemukan.',
        ]);
    }

    $dataPemeriksaan->data_pasien_id = $validated['pilihPasien'];

    if ($request->boolean('pakaiPendamping')) {
        $dataPemeriksaan->namaPendamping  = $validated['namaPendamping'];
        $dataPemeriksaan->nomorPendamping  = $validated['nomorPendamping'];
        $dataPemeriksaan->hubunganPendamping = $validated['hubunganPendamping'];
    } else {
        $dataPemeriksaan->namaPendamping  = null;
        $dataPemeriksaan->nomorPendamping  = null;
        $dataPemeriksaan->hubunganPendamping = null;
    }

    $dataPemeriksaan->riwayatAlamatDomisili = $dataPasien->alamatDomisili;
    $dataPemeriksaan->riwayatTanggalLahir = $dataPasien->tanggalLahir;
    $dataPemeriksaan->riwayatJenisKelamin = $dataPasien->jenisKelamin;
    $dataPemeriksaan->riwayatNoHP = $dataPasien->noHP;
    $dataPemeriksaan->riwayatAlergi = $dataPasien->alergi;
    $dataPemeriksaan->riwayatGolonganDarah = $dataPasien->golonganDarah;

    $dataPemeriksaan->save();

    return redirect()->route('petugas.daftardatarujukan', $masterPasien);
}


    public function finalisasiDraft(Request $request, DataPemeriksaan $dataPemeriksaan){
        $dataPemeriksaan->statusUtama = 'Pending';
        $dataPemeriksaan->statusDokter = 'Pendaftaran Baru';
        $dataPemeriksaan->statusPetugas = 'Pendaftaran Baru';
        $dataPemeriksaan->statusPasien = 'Pendaftaran Terkirim';
        $dataPemeriksaan->save();
        
        return redirect()->route('pasien.pendaftaran');
    }

    public function finalisasiDraftPetugas(Request $request, DataPemeriksaan $dataPemeriksaan){
        $dataPemeriksaan->statusUtama = 'Pending';
        $dataPemeriksaan->statusDokter = 'Pendaftaran Baru';
        $dataPemeriksaan->statusPetugas = 'Pendaftaran Baru';
        $dataPemeriksaan->statusPasien = 'Pendaftaran Terkirim';
        $dataPemeriksaan->save();
        $petugas = auth()->user()->petugas;
        LogService::create('Membuat pendaftaran dengan id: '.$dataPemeriksaan->id, $petugas->id);
        
        return redirect()->route('petugas.homepage');
    }    

    public function hapusPendaftaran(Request $request, DataPemeriksaan $dataPemeriksaan){
        
        $dataPemeriksaan->statusUtama = "Dibatalkan";
        $dataPemeriksaan->statusPasien = "Pendaftaran Dibatalkan";
        $dataPemeriksaan->statusPetugas = "Pendaftaran Dibatalkan";
        $dataPemeriksaan->statusDokter = "Pendaftaran Dibatalkan";
        $dataPemeriksaan->cancelled_at = now();

        $dataPemeriksaan->save();
        return redirect()->route('pasien.pendaftaran');
    }

    //ganti status dari hasil tersedia ke selesai
    public function selesaiPemeriksaan(Request $request, DataPemeriksaan $dataPemeriksaan){
        if ($dataPemeriksaan->statusPasien === "Hasil Tersedia"){
            $dataPemeriksaan->statusUtama = "Selesai";
            $dataPemeriksaan->statusPasien = "Selesai";
            $dataPemeriksaan->statusPetugas = "Selesai";
            $dataPemeriksaan->statusDokter = "Selesai";
    
            $dataPemeriksaan->save();
        }
        return redirect()->route('pasien.pendaftaran');
    }
    
    public function homepageDokter(Request $request){ 
        $dokter = auth()->user()->dokter;

        $status = $request->input('status', 'semua');
        $search = $request->input('search');

        // dd($status);

        $query = $dokter->dataPemeriksaan()
                ->with(['dataPasien', 'dataRujukan', 'jenisPemeriksaan', 'dokter.user'])
                //with ini buat ngehindarin N+1 problem (lazy loading), jadi better ambil data relasiannya langsung
                ->whereNotIn('statusDokter', [
                    'Menunggu Registrasi Ulang',
                    'Menunggu Pembayaran Offline',
                ]);

        $statusMap = [
            'berlangsung' => 'Berlangsung',
            'selesai' => 'Selesai',
        ];

        if ($status !== 'semua' && isset($statusMap[$status])) {
            $query->where('statusUtama', $statusMap[$status]);
        }


        if ($search) {
            $search = trim($search);

            $query->where(function ($sub) use ($search) {
                //Search jadinya kupindahin ke backend soalnya kalo di JS, dia gabisa filter yang page berikutnya di pagination
                    // Ini buat nama pasien
                    $sub->whereHas('dataPasien', function ($q) use ($search) {
                        $q->where('namaLengkap', 'like', "%{$search}%");
                    })
                    // Ini buat dokter perujuk
                    ->orWhereHas('dataRujukan', function ($q) use ($search) {
                        $q->where('namaDokterPerujuk', 'like', "%{$search}%");
                    })
                    // Jenis pemeriksaan 
                    ->orWhereHas('jenisPemeriksaan', function ($q) use ($search) {
                        $q->where('namaJenisPemeriksaan', 'like', "%{$search}%");
                    })
                    // Dokter radiologi 
                    ->orWhereHas('dokter.user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $list = $query
        ->orderBy('created_at', 'desc')
        ->paginate(10)          
        ->withQueryString(); //ini buat ngebawa ?status=

        return view('dokter.homepage', compact('dokter', 'list'));
    }

   public function registrasiUlang(Request $request, DataPemeriksaan $dataPemeriksaan) {
        if ($dataPemeriksaan->statusPasien !== 'Menunggu Registrasi Ulang'){
            return back()->with('error', 'Pasien tidak dalam status Menunggu Registrasi Ulang.');
        }
        $kelompokJenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan->kelompokJenisPemeriksaan;
        $counter = $dataPemeriksaan->rumahSakit->counterHariIni($kelompokJenisPemeriksaan->id);
        if ($counter === null) {
            $counter = CounterAntrian::create([
                'rumah_sakit_id' => $dataPemeriksaan->rumah_sakit_id,
                'kelompok_jenis_pemeriksaan_id' => $kelompokJenisPemeriksaan->id,
                'tanggalAntrian' => Carbon::today(),
                'nomorTerakhir' => 0,
            ]);
        }
        $counter->nomorTerakhir++;
        $counter->save();
        
        $dataPemeriksaan->nomorAntrian = $counter->nomorTerakhir;
        $dataPemeriksaan->statusPasien = $dataPemeriksaan->statusPetugas = $dataPemeriksaan->statusDokter = 'Dalam Antrian';
        $dataPemeriksaan->save();
        $petugas = auth()->user()->petugas;
        LogService::create('Meregistrasi ulang pendaftaran dengan id: '.$dataPemeriksaan->id, $petugas->id);

        return redirect()->route('petugas.homepage');
    }
}



