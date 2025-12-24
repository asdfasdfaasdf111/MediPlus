<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KelompokJenisPemeriksaan;
use App\Services\LogService;
use Illuminate\Http\Request;

class KelompokJenisPemeriksaanController extends Controller
{
    public function tambahKelompokJenisPemeriksaan(Request $request){
        $request->validate([
            'namaKelompok' => 'required|string|max:100',
        ]);

        $kelompokJenisPemeriksaan = KelompokJenisPemeriksaan::create([
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'namaKelompok' => $request->namaKelompok,
        ]);

        $petugas = auth()->user()->petugas;

        LogService::create('Membuat kelompok jenis baru baru dengan id: '.$kelompokJenisPemeriksaan->id, $petugas->id);
        return redirect()->route('petugas.kelolakelompokjenispemeriksaan')->with('success', 'Kelompok Jenis Pemeriksaan berhasil dibuat!');
    }

    public function editKelompokJenisPemeriksaan(Request $request, $id){
        $kelompokJenisPemeriksaan = KelompokJenisPemeriksaan::findOrFail($id);
        
        $request->validate([
            'namaKelompok' => 'required|string|max:100',
            // 'jenisModalitas' => 'required|string|max:100',
            // 'kodeRuang' => 'required|string|max:100',
        ]);
        
        $kelompokJenisPemeriksaan->namaKelompok = $request->input('namaKelompok');
        $petugas = auth()->user()->petugas;

        $kelompokJenisPemeriksaan->save();
        LogService::create('Mengupdate kelompok jenis pemeriksaan dengan id: '.$kelompokJenisPemeriksaan->id, $petugas->id);

        return response()->json([
            'success' => true,
            ]);
    }

    public function hapusKelompokJenisPemeriksaan($id){
        $kelompokJenisPemeriksaan = KelompokJenisPemeriksaan::findOrFail($id);
        $kelompokJenisPemeriksaan->delete();
        $petugas = auth()->user()->petugas;
        LogService::create('Menghapus kelompok jenis pemeriksaan dengan id: '.$id, $petugas->id);
    
        return redirect()->back()->with('success', 'Kelompok jenis pemeriksaan berhasil dihapus.');
    }

    public function tampilkanKelompokJenisPemeriksaan(Request $request)
    {
        $petugas = auth()->user()->petugas;
        $rumahSakit = $petugas->rumahSakit;
        
        $kelompokJenisPemeriksaans = $rumahSakit->kelompokJenisPemeriksaan()
        ->when($request->search, function ($query, $search) {
            $query->where('namaKelompok', 'like', "%{$search}%");
        })
        ->get();
        
        return view('petugas.kelolakelompokjenispemeriksaan', compact('kelompokJenisPemeriksaans'));
    }
}
