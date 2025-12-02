<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataPemeriksaan;
use App\Models\HasilPemeriksaan;
use App\Models\JenisPemeriksaan;
use Illuminate\Http\Request;

class HasilPemeriksaanController extends Controller
{
    public function bikinHasilPemeriksaan(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'files.*' => 'required|file',
            'deskripsi' => 'required|string',
        ]);

        $uploadedFiles = [];

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads', 'public');
                $uploadedFiles[] = $path;
            }
        }

        HasilPemeriksaan::create([
            'data_pemeriksaan_id' => $dataPemeriksaan->id,
            'dokter_id' => $dataPemeriksaan->dokter->id,
            'data_pasien_id' => $dataPemeriksaan->dataPasien->id,
            'hasilPemeriksaan' => $request->deskripsi,
            'fileLampiran' => json_encode($uploadedFiles),
        ]);

        $dataPemeriksaan->statusPasien = 'Hasil Tersedia';
        $dataPemeriksaan->statusDokter = 'Laporan Terkirim';
        $dataPemeriksaan->save();

        return redirect()->route('dokter.homepage')->with('success', 'Laporan Berhasil Ditambahkan!');
    }
}
