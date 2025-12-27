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
            'lamaPemeriksaan' => 'required|integer|min:1',
        ],
        [
            'namaJenisPemeriksaan.required' => 'Nama Jenis Pemeriksaan wajib diisi.',
            'lamaPemeriksaan.required' => 'Lama Pemeriksaan wajib diisi.',
        ]);

        $jenisPemeriksaan = JenisPemeriksaan::create([
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'kelompok_jenis_pemeriksaan_id' => $request->kelompokJenisPemeriksaan,
            'namaJenisPemeriksaan' => $request->namaJenisPemeriksaan,
            'pemakaianKontras' => $request->pemakaianKontras,
            'lamaPemeriksaan' => $request->lamaPemeriksaan,
            'diDampingiDokter' => $request->diDampingiDokter,
        ]);
        $petugas = auth()->user()->petugas;

        LogService::create('Membuat jenis pemeriksaan baru dengan id: '.$jenisPemeriksaan->id, $petugas->id);

        return redirect()->route('petugas.kelolajenispemeriksaan')->with('success', 'Berhasil menambahkan Jenis Pemeriksaan!');
    }

    public function editJenisPemeriksaan(Request $request, $id){
        $jenisPemeriksaan = JenisPemeriksaan::findOrFail($id);

        $request->validate([
            'namaJenisPemeriksaan' => 'required|string|max:100',
            'lamaPemeriksaan' => 'required|integer|min:1',
        ]);

        $jenisPemeriksaan->kelompok_jenis_pemeriksaan_id = $request->input('kelompokJenisPemeriksaan');
        $jenisPemeriksaan->namaJenisPemeriksaan = $request->input('namaJenisPemeriksaan');
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

        $search = trim($request->search ?? '');

        $query = $rumahSakit->jenisPemeriksaan()
            ->with('kelompokJenisPemeriksaan');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {

                $q->whereHas('kelompokJenisPemeriksaan', function ($kq) use ($search) {
                    $kq->where('namaKelompok', 'like', "%{$search}%");
                })

                ->orWhere('namaJenisPemeriksaan', 'like', "%{$search}%");

                if (is_numeric($search)) {
                    $q->orWhere('lamaPemeriksaan', (int) $search);
                }

                if (strtolower($search) === 'ya') {
                    $q->orWhere('pemakaianKontras', true)
                    ->orWhere('diDampingiDokter', true);
                }

                if (strtolower($search) === 'tidak') {
                    $q->orWhere('pemakaianKontras', false)
                    ->orWhere('diDampingiDokter', false);
                }
            });
        }

        $jenisPemeriksaans = $query
            ->orderBy('namaJenisPemeriksaan', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('petugas.kelolajenispemeriksaan', [
            'petugas'           => $petugas,
            'jenisPemeriksaans' => $jenisPemeriksaans,
        ]);
    }

}
