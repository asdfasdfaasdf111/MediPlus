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
        if ($jenisPemeriksaan->diDampingiDokter && !$dokter->available($dataPemeriksaan->tanggalPemeriksaan, $dataPemeriksaan->rentangWaktuKedatangan, $jenisPemeriksaan->lamaPemeriksaan)) {
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
}
