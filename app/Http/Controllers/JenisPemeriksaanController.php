<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisPemeriksaan;
use App\Models\KelompokJenisPemeriksaan;
use App\Models\Modalitas;
use App\Models\RumahSakit;
use App\Services\LogService;
use Illuminate\Http\Request;

class JenisPemeriksaanController extends Controller
{
    public function tambahJenisPemeriksaan(Request $request){
        $request->validate([
            'namaJenisPemeriksaan' => 'required|string|max:100',
            'namaPemeriksaanSpesifik' => 'required|string|max:100',
            'kelompokJenisPemeriksaan' => 'required|string|max:100',
            'lamaPemeriksaan' => 'required|integer|min:1',
        ]);

        $jenisPemeriksaan = JenisPemeriksaan::create([
            'modalitas_id' => $request->modalitasId,
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'namaJenisPemeriksaan' => $request->namaJenisPemeriksaan,
            'namaPemeriksaanSpesifik' => $request->namaPemeriksaanSpesifik,
            'kelompokJenisPemeriksaan' => $request->kelompokJenisPemeriksaan,
            'pemakaianKontras' => $request->pemakaianKontras,
            'lamaPemeriksaan' => $request->lamaPemeriksaan,
            'diDampingiDokter' => $request->diDampingiDokter,
        ]);
        $petugas = auth()->user()->petugas;

        LogService::create('Membuat jenis pemeriksaan baru dengan id: '.$jenisPemeriksaan->id, $petugas->id);
        return redirect()->route('petugas.kelolajenispemeriksaan')->with('success', 'Jenis Pemeriksaan berhasil dibuat!');
    }

    public function editJenisPemeriksaan(Request $request, $id){
        $jenisPemeriksaan = JenisPemeriksaan::findOrFail($id);

        $request->validate([
            'namaJenisPemeriksaan' => 'required|string|max:100',
            // 'namaPemeriksaanSpesifik' => 'required|string|max:100',
            // 'kelompokJenisPemeriksaan' => 'required|string|max:100',
            'lamaPemeriksaan' => 'required|integer|min:1',
        ]);

        $jenisPemeriksaan->kelompok_jenis_pemeriksaan_id = $request->input('kelompokJenisPemeriksaan');
        $jenisPemeriksaan->namaJenisPemeriksaan = $request->input('namaJenisPemeriksaan');
        // $jenisPemeriksaan->namaPemeriksaanSpesifik = $request->input('namaPemeriksaanSpesifik');
        // $jenisPemeriksaan->kelompokJenisPemeriksaan = $request->input('kelompokJenisPemeriksaan');
        $jenisPemeriksaan->pemakaianKontras = $request->input('pemakaianKontras');
        $jenisPemeriksaan->lamaPemeriksaan = $request->input('lamaPemeriksaan');
        $jenisPemeriksaan->diDampingiDokter = $request->input('diDampingiDokter');

        $jenisPemeriksaan->save();

        $petugas = auth()->user()->petugas;
        LogService::create('Mengupdate jenis pemeriksaan dengan id: '.$jenisPemeriksaan->id, $petugas->id);
        return response()->json([
            'success' => true,
            'namaKelompokJenisPemeriksaan' => KelompokJenisPemeriksaan::findOrFail($jenisPemeriksaan->kelompok_jenis_pemeriksaan_id)->namaKelompok
            ]);
    }

    public function hapusJenisPemeriksaan($id){
        $jenisPemeriksaan = JenisPemeriksaan::findOrFail($id);
        $jenisPemeriksaan->delete();
        $petugas = auth()->user()->petugas;
        
        LogService::create('Menghapus jenis pemeriksaan dengan id: '.$id, $petugas->id);
        return redirect()->back()->with('success', 'Jenis Pemeriksaan berhasil dihapus.');
    }

    public function tampilkanJenisPemeriksaan(Request $request)
    {
        $petugas = auth()->user()->petugas;
        $rumahSakit = $petugas->rumahSakit;
        
        $jenisPemeriksaans = $rumahSakit->jenisPemeriksaan()
        ->when($request->search, function ($query, $search) {
            $query->whereHas('kelompokJenisPemeriksaan', function ($q) use ($search){
                $q->where('namaKelompok', 'like', "%{$search}%");
            })
            ->orWhere('namaJenisPemeriksaan', 'like', "%{$search}%");
        })
        ->get();
        
        return view('petugas.kelolajenispemeriksaan', compact('jenisPemeriksaans'));
    }
}
