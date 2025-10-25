<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataPemeriksaan;
use App\Models\Dokter;
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

    public function updateJadwal(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'jenisPemeriksaan' => 'required|string',
            'jenisPemeriksaanSpesifik' => 'required|string',
            'tanggalPemeriksaan' => 'required|date',
            'rentangWaktuKedatangan' => 'required|date_format:H:i',
        ]);
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

        if (empty($dataPemeriksaan->historyJenisPemeriksaan)) {
            $dataPemeriksaan->historyJenisPemeriksaan = $dataPemeriksaan->jenis_pemeriksaan_id;
            $dataPemeriksaan->historyTanggalPemeriksaan = $dataPemeriksaan->tanggalPemeriksaan;
            $dataPemeriksaan->historyJamPemeriksaan = $dataPemeriksaan->rentangWaktuKedatangan;
        }
        $dataPemeriksaan->jenis_pemeriksaan_id = $jenisPemeriksaan->id;
        $dataPemeriksaan->tanggalPemeriksaan = $request->tanggalPemeriksaan;
        $dataPemeriksaan->rentangWaktuKedatangan = $request->rentangWaktuKedatangan;
        $dataPemeriksaan->save();
        return redirect()->route('petugas.pratinjaupemeriksaan', $dataPemeriksaan);
    }
}
