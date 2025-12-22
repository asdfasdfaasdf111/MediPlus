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
        ],
        [
            'namaFaskes.required'            => 'Nama fasilitas kesehatan wajib diisi.',
            'namaDokterPerujuk.required'     => 'Nama dokter perujuk wajib diisi.',
            'diagnosaKerja.required'         => 'Diagnosa kerja wajib diisi.',
            'alasanRujukan.required'         => 'Alasan rujukan wajib diisi.',
            'permintaanPemeriksaan.required' => 'Permintaan pemeriksaan wajib diisi.',
            'tanggalPemeriksaanFaskes.required' => 'Tanggal pemeriksaan di faskes wajib diisi.',
            'tanggalPemeriksaanFaskes.before_or_equal' => 'Tanggal pemeriksaan di faskes tidak boleh setelah hari ini.',
            'formulirRujukan.required'       => 'Formulir rujukan wajib diunggah.',
            'formulirRujukan.mimes'          => 'Formulir rujukan harus berupa file PDF.',
            'formulirRujukan.max'            => 'Ukuran file maksimal 8 MB.',
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

    public function bikinDataRujukanPetugas(Request $request, DataPemeriksaan $dataPemeriksaan){
        $request->validate([
            'namaFaskes' => 'required|string',
            'namaDokterPerujuk' => 'required|string',
            'diagnosaKerja' => 'required|string',
            'alasanRujukan' => 'required|string',
            'permintaanPemeriksaan' => 'required|string',
            'tanggalPemeriksaanFaskes' => 'required|date|before_or_equal:today',
            'formulirRujukan' => 'required|mimes:pdf|max:8192',
        ],
        [
            'namaFaskes.required'            => 'Nama fasilitas kesehatan wajib diisi.',
            'namaDokterPerujuk.required'     => 'Nama dokter perujuk wajib diisi.',
            'diagnosaKerja.required'         => 'Diagnosa kerja wajib diisi.',
            'alasanRujukan.required'         => 'Alasan rujukan wajib diisi.',
            'permintaanPemeriksaan.required' => 'Permintaan pemeriksaan wajib diisi.',
            'tanggalPemeriksaanFaskes.required' => 'Tanggal pemeriksaan di faskes wajib diisi.',
            'tanggalPemeriksaanFaskes.before_or_equal' => 'Tanggal pemeriksaan di faskes tidak boleh setelah hari ini.',
            'formulirRujukan.required'       => 'Formulir rujukan wajib diunggah.',
            'formulirRujukan.mimes'          => 'Formulir rujukan harus berupa file PDF.',
            'formulirRujukan.max'            => 'Ukuran file maksimal 8 MB.',
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
        
        return redirect()->route('petugas.daftarringkasan', $dataPemeriksaan->masterPasien);
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
        ],
        [
            'namaFaskes.required' => 'Nama fasilitas kesehatan wajib diisi.',
            'namaDokterPerujuk.required' => 'Nama dokter perujuk wajib diisi.',
            'diagnosaKerja.required' => 'Diagnosa kerja wajib diisi.',
            'alasanRujukan.required' => 'Alasan rujukan wajib diisi.',
            'permintaanPemeriksaan.required' => 'Permintaan pemeriksaan wajib diisi.',
            'tanggalPemeriksaanFaskes.required' => 'Tanggal pemeriksaan di faskes wajib diisi.',
            'tanggalPemeriksaanFaskes.before_or_equal' => 'Tanggal pemeriksaan di faskes tidak boleh setelah hari ini.',
            'formulirRujukan.mimes' => 'Formulir rujukan harus berupa file PDF.',
            'formulirRujukan.max' => 'Ukuran file maksimal 8 MB.',
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
    
    public function updateDataRujukanPetugas(Request $request, DataPemeriksaan $dataPemeriksaan, DataRujukan $dataRujukan){
        $request->validate([
            'namaFaskes' => 'required|string',
            'namaDokterPerujuk' => 'required|string',
            'diagnosaKerja' => 'required|string',
            'alasanRujukan' => 'required|string',
            'permintaanPemeriksaan' => 'required|string',
            'tanggalPemeriksaanFaskes' => 'required|date|before_or_equal:today',
            'formulirRujukan' => 'nullable|file|mimes:pdf|max:8192',
        ],
        [
        'namaFaskes.required' => 'Nama fasilitas kesehatan wajib diisi.',
        'namaDokterPerujuk.required' => 'Nama dokter perujuk wajib diisi.',
        'diagnosaKerja.required' => 'Diagnosa kerja wajib diisi.',
        'alasanRujukan.required' => 'Alasan rujukan wajib diisi.',
        'permintaanPemeriksaan.required' => 'Permintaan pemeriksaan wajib diisi.',
        'tanggalPemeriksaanFaskes.required' => 'Tanggal pemeriksaan di faskes wajib diisi.',
        'tanggalPemeriksaanFaskes.before_or_equal' => 'Tanggal pemeriksaan di faskes tidak boleh setelah hari ini.',
        'formulirRujukan.mimes' => 'Formulir rujukan harus berupa file PDF.',
        'formulirRujukan.max' => 'Ukuran file maksimal 8 MB.',
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

        
        return redirect()->route('petugas.daftarringkasan', $dataPemeriksaan->masterPasien);
    }
}