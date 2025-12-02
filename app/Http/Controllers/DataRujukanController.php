<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataPemeriksaan;
use App\Models\DataRujukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataRujukanController extends Controller
{
    public function bikinDataRujukan(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'namaFaskes' => 'required|string',
            'namaDokterPerujuk' => 'required|string',
            'diagnosaKerja' => 'required|string',
            'alasanRujukan' => 'required|string',
            'permintaanPemeriksaan' => 'required|string',
            'tanggalPemeriksaanFaskes' => 'required|date|before_or_equal:today',
            'formulirRujukan' => 'required|mimes:pdf|max:8192',
        ]);

        $path = $request->file('formulirRujukan')->store('uploads', 'public');

        $dataRujukan = DataRujukan::create([
            'data_pasien_id' => $dataPemeriksaan->data_pasien_id,
            'namaFaskes' => $request->namaFaskes,
            'namaDokterPerujuk' => $request->namaDokterPerujuk,
            'diagnosaKerja' => $request->diagnosaKerja,
            'alasanRujukan' => $request->alasanRujukan,
            'tanggalPemeriksaanFaskes' => $request->tanggalPemeriksaanFaskes,
            'permintaanPemeriksaan' => $request->permintaanPemeriksaan,
            'formulirRujukan' => $path,
            'namaFile' => $request->file('formulirRujukan')->getClientOriginalName(),
        ]);

        $dataPemeriksaan->data_rujukan_id = $dataRujukan->id;
        $dataPemeriksaan->save();
        
        return redirect()->route('pasien.daftarringkasan');
    }

    public function updateDataRujukan(Request $request, DataPemeriksaan $dataPemeriksaan, DataRujukan $dataRujukan){
        $request->validate([
            'namaFaskes' => 'required|string',
            'namaDokterPerujuk' => 'required|string',
            'diagnosaKerja' => 'required|string',
            'alasanRujukan' => 'required|string',
            'permintaanPemeriksaan' => 'required|string',
            'tanggalPemeriksaanFaskes' => 'required|date|before_or_equal:today',
            'formulirRujukan' => 'nullable|file|mimes:pdf|max:8192',
        ]);

        if (!is_null($dataPemeriksaan->formulirRujukan)) {
            $path = $request->file('formulirRujukan')->store('uploads', 'public');
            if (!empty($dataRujukan->formulirRujukan) && Storage::disk('public')->exists($dataRujukan->formulirRujukan)) {
                Storage::disk('public')->delete($dataRujukan->formulirRujukan);
            }
            $dataRujukan->formulirRujukan = $path;
            $dataRujukan->namaFile = $request->file('formulirRujukan')->getClientOriginalName();
        } 

        $dataRujukan->data_pasien_id = $dataPemeriksaan->data_pasien_id;
        $dataRujukan->namaFaskes = $request->namaFaskes;
        $dataRujukan->namaDokterPerujuk = $request->namaDokterPerujuk;
        $dataRujukan->diagnosaKerja = $request->diagnosaKerja;
        $dataRujukan->alasanRujukan = $request->alasanRujukan;
        $dataRujukan->tanggalPemeriksaanFaskes = $request->tanggalPemeriksaanFaskes;
        $dataRujukan->permintaanPemeriksaan = $request->permintaanPemeriksaan;
        
        $dataRujukan->save();

        
        return redirect()->route('pasien.daftarringkasan');
    }
}
