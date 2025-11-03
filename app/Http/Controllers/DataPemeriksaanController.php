<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataPemeriksaan;
use App\Models\Dokter;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class DataPemeriksaanController extends Controller
{
    public function updatePendaftaran(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'status' => 'required|in:accepted,rejected',
            'dokterId' => 'required|exists:dokters,id',
        ]);
        $dokter = Dokter::findOrFail($request->dokterId);
        $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
        if (!$dokter->available($dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan->rentangWaktuKedatangan, $jenisPemeriksaan->lamaPemeriksaan, $jenisPemeriksaan)) {
            return back()->withErrors([
                'dokter_id' => 'Dokter ini tidak tersedia pada jadwal tersebut',
            ]);
        }

        if ($request->status == 'accepted'){
            $dataPemeriksaan->statusUtama = "Berlangsung";
            $dataPemeriksaan->statusPasien = "Menunggu Registrasi Ulang";
            $dataPemeriksaan->statusPetugas = "Menunggu Registrasi Ulang";
            $dataPemeriksaan->statusDokter = "Menunggu Registrasi Ulang";
            $dataPemeriksaan->dokter_id = $request->dokterId;
        }
        else{
            $dataPemeriksaan->statusUtama = "Dibatalkan";
            $dataPemeriksaan->statusPasien = "Pendaftaran Ditolak";
            $dataPemeriksaan->statusPetugas = "Pendaftaran Ditolak";
            $dataPemeriksaan->statusDokter = "Pendaftaran Ditolak";
        }
        $dataPemeriksaan->save();
        return redirect()->route('petugas.homepage');
    }

    public function updateJadwal(Request $request, DataPemeriksaan $dataPemeriksaan, $draft){
        $request->validate([
            'jenisPemeriksaan' => 'required|string',
            'jenisPemeriksaanSpesifik' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);
        
        
        if ($draft == "1" || $draft == "true") $draft = true;
        else $draft = false;

        $user = auth()->user();

        if ($user->role == "pasien") {
            //kalo data yg mau diedit bukan punyanya, error
            if ($dataPemeriksaan->masterPasien->user->id !== $user->id) {
                return back()->withErrors([
                    'salahData' => 'Anda tidak bisa mengubah data pemeriksaan ini',
                ]);
            }
        }
        else if ($user->role !== "superadmin"){
            //kalo yang mau diedit itu data rumah sakit lain
            $rumahSakitId = optional($user->admin)->rumah_sakit_id
                            ?? optional($user->petugas)->rumah_sakit_id
                            ?? optional($user->dokter)->rumah_sakit_id;
            if ($dataPemeriksaan->rumah_sakit_id !== $rumahSakitId) {
                return back()->withErrors([
                    'salahData' => 'Anda tidak bisa mengubah data pemeriksaan ini',
                ]);
            }
        }

        $rumahSakit = $dataPemeriksaan->rumahSakit;
        $jenisPemeriksaan = $rumahSakit->jenisPemeriksaan()
                                        ->where('id', $request->jenisPemeriksaanSpesifik)
                                        ->get()
                                        ->first();
        if (!$jenisPemeriksaan){
            return back()->withErrors([
                'jenisPemeriksaan' => 'Jenis Pemeriksaan ini tidak ada',
            ]);
        }

        $listJam = $rumahSakit->jamTersedia($jenisPemeriksaan, $request->tanggalPemeriksaan, $dataPemeriksaan);
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

        if (!$draft && empty($dataPemeriksaan->historyJenisPemeriksaan)) {
            $dataPemeriksaan->historyJenisPemeriksaan = $dataPemeriksaan->jenis_pemeriksaan_id;
            $dataPemeriksaan->historyTanggalPemeriksaan = $dataPemeriksaan->tanggalPemeriksaan;
            $dataPemeriksaan->historyJamPemeriksaan = $dataPemeriksaan->rentangWaktuKedatangan;
        }
        $dataPemeriksaan->jenis_pemeriksaan_id = $jenisPemeriksaan->id;
        $dataPemeriksaan->tanggalPemeriksaan = $request->tanggalPemeriksaan;
        $dataPemeriksaan->rentangWaktuKedatangan = $request->rentangWaktuKedatangan;
        $dataPemeriksaan->save();
        
        if (!$draft){
            return redirect()->route('petugas.pratinjaupemeriksaan', $dataPemeriksaan);
        }
        else{
            return redirect()->route('pasien.daftartipepasien');
        }
    }

    public function bikinDraft(Request $request){
        $request->validate([
            'rumahSakit' => 'required|string',
            'jenisPemeriksaan' => 'required|string',
            'jenisPemeriksaanSpesifik' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);

        $rumahSakit = RumahSakit::find($request->rumahSakit);
        $jenisPemeriksaan = $rumahSakit->jenisPemeriksaan()
                                        ->where('id', $request->jenisPemeriksaanSpesifik)
                                        ->get()
                                        ->first();
        if (!$jenisPemeriksaan){
            return back()->withErrors([
                'jenisPemeriksaan' => 'Jenis Pemeriksaan ini tidak ada',
            ]);
        }

        $user = auth()->user();

        $listJam = $rumahSakit->jamTersedia($jenisPemeriksaan, $request->tanggalPemeriksaan);
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
            'statusDokter' => 'Draft',
            'statusPetugas' => 'Draft',
            'statusPasien' => 'Draft',
        ]);
        
        return redirect()->route('pasien.daftartipepasien');
    }

    public function updateTipePasien(Request $request, DataPemeriksaan $dataPemeriksaan){
        $masterPasien = auth()->user()->masterPasien;

        $dataPasien = $masterPasien->dataPasien()
                                    ->where('id', $request->pilihPasien)
                                    ->first();
        
        if (!$dataPasien){
            return back()->withErrors([
                'dataPasien' => 'Data Pasien ini tidak ada',
            ]);
        }

        $dataPemeriksaan->data_pasien_id = $request->pilihPasien;
        $dataPemeriksaan->namaPendamping = $request->namaPendamping;
        $dataPemeriksaan->nomorPendamping = $request->nomorPendamping;
        $dataPemeriksaan->hubunganPendamping = $request->hubunganPendamping;
        $dataPemeriksaan->riwayatAlamatDomisili = $dataPasien->riwayatAlamatDomisili;
        $dataPemeriksaan->riwayatTanggalLahir = $dataPasien->riwayatTanggalLahir;
        $dataPemeriksaan->riwayatJenisKelamin = $dataPasien->riwayatJenisKelamin;
        $dataPemeriksaan->riwayatNoHP = $dataPasien->riwayatNoHP;
        $dataPemeriksaan->riwayatAlergi = $dataPasien->riwayatAlergi;
        $dataPemeriksaan->riwayatGolonganDarah = $dataPasien->riwayatGolonganDarah;
        $dataPemeriksaan->save();
        
        return redirect()->route('pasien.daftardatarujukan');
    }

    public function finalisasiDraft(Request $request, DataPemeriksaan $dataPemeriksaan){
        $dataPemeriksaan->statusUtama = 'Pending';
        $dataPemeriksaan->statusDokter = 'Pendaftaran Baru';
        $dataPemeriksaan->statusPetugas = 'Pendaftaran Baru';
        $dataPemeriksaan->statusPasien = 'Pendaftaran Terkirim';
        $dataPemeriksaan->save();
        
        return redirect()->route('pasien.pendaftaran');
    }
}
