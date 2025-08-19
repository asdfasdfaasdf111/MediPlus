<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisPemeriksaan;
use Illuminate\Http\Request;

class JenisPemeriksaanController extends Controller
{
    public function tambahJenisPemeriksaan(Request $request){
        $request->validate([
            'namaJenisPemeriksaan' => 'required|string|max:100',
            'namaPemeriksaanSpesifik' => 'required|string|max:100',
            'kelompokJenisPemeriksaan' => 'required|string|max:100',
            'lamaPemeriksaan' => 'required|min:0',
        ]);

        $lamaPemeriksaan  = sprintf("%02d:%02d", $request->lamaPemeriksaan / 60, $request->lamaPemeriksaan % 60);

        JenisPemeriksaan::create([
            'modalitas_id' => $request->modalitasId,
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'namaJenisPemeriksaan' => $request->namaJenisPemeriksaan,
            'namaPemeriksaanSpesifik' => $request->namaPemeriksaanSpesifik,
            'kelompokJenisPemeriksaan' => $request->kelompokJenisPemeriksaan,
            'pemakaianKontras' => $request->pemakaianKontras,
            'lamaPemeriksaan' => $lamaPemeriksaan,
            'diDampingiDokter' => $request->diDampingiDokter,
        ]);

        return redirect()->route('petugas.kelolajenispemeriksaan')->with('success', 'Jenis Pemeriksaan berhasil dibuat!');
    }


    public function hapusJenisPemeriksaan($id){
        $jenisPemeriksaan = JenisPemeriksaan::findOrFail($id);
        $jenisPemeriksaan->delete();
    
        return redirect()->back()->with('success', 'Jenis Pemeriksaan berhasil dihapus.');
    }
}
