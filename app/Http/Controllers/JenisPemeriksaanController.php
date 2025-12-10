<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\JenisPemeriksaan;
use App\Models\Modalitas;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class JenisPemeriksaanController extends Controller
{
    public function tambahJenisPemeriksaan(Request $request){
        $request->validate([
            'namaJenisPemeriksaan' => 'required|string|max:100',
            'namaPemeriksaanSpesifik' => 'required|string|max:100',
            'kelompokJenisPemeriksaan' => 'required|string|max:100',
            'lamaPemeriksaan' => 'required|integer|min:1',
        ],
        [
            'namaJenisPemeriksaan.required' => 'Nama Jenis Pemeriksaan wajib diisi.',
            'namaPemeriksaanSpesifik.required' => 'Nama Pemeriksaan Spesifik wajib diisi.',
            'kelompokJenisPemeriksaan.required' => 'Kelompok Jenis Pemeriksaan wajib diisi.',
            'lamaPemeriksaan.required' => 'Lama Pemeriksaan wajib diisi.',
        ]);

        JenisPemeriksaan::create([
            'modalitas_id' => $request->modalitasId,
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'namaJenisPemeriksaan' => $request->namaJenisPemeriksaan,
            'namaPemeriksaanSpesifik' => $request->namaPemeriksaanSpesifik,
            'kelompokJenisPemeriksaan' => $request->kelompokJenisPemeriksaan,
            'pemakaianKontras' => $request->pemakaianKontras,
            'lamaPemeriksaan' => $request->lamaPemeriksaan,
            'diDampingiDokter' => $request->diDampingiDokter,
        ]);

        return redirect()->route('petugas.kelolajenispemeriksaan')->with('success', 'Berhasil menambahkan Jenis Pemeriksaan!');
    }

    public function editJenisPemeriksaan(Request $request, $id){
        $jenisPemeriksaan = JenisPemeriksaan::findOrFail($id);

        $request->validate([
            'namaJenisPemeriksaan' => 'required|string|max:100',
            'namaPemeriksaanSpesifik' => 'required|string|max:100',
            'kelompokJenisPemeriksaan' => 'required|string|max:100',
            'lamaPemeriksaan' => 'required|integer|min:1',
        ]);

        $jenisPemeriksaan->modalitas_id = $request->input('modalitasId');
        $jenisPemeriksaan->namaJenisPemeriksaan = $request->input('namaJenisPemeriksaan');
        $jenisPemeriksaan->namaPemeriksaanSpesifik = $request->input('namaPemeriksaanSpesifik');
        $jenisPemeriksaan->kelompokJenisPemeriksaan = $request->input('kelompokJenisPemeriksaan');
        $jenisPemeriksaan->pemakaianKontras = $request->input('pemakaianKontras');
        $jenisPemeriksaan->lamaPemeriksaan = $request->input('lamaPemeriksaan');
        $jenisPemeriksaan->diDampingiDokter = $request->input('diDampingiDokter');

        $jenisPemeriksaan->save();

        return response()->json([
            'success' => true,
            'namaModalitas' => Modalitas::findOrFail($jenisPemeriksaan->modalitas_id)->namaModalitas
            ]);
    }

    public function hapusJenisPemeriksaan($id){
        $jenisPemeriksaan = JenisPemeriksaan::findOrFail($id);
        $jenisPemeriksaan->delete();
    
        return redirect()->back()->with('success', 'Berhasil menghapus Jenis Pemeriksaan!');
    }

    public function tampilkanJenisPemeriksaan(Request $request)
    {
        $petugas = auth()->user()->petugas;
        $rumahSakit = $petugas->rumahSakit;

        $search = trim($request->search ?? '');

        $query = $rumahSakit->jenisPemeriksaan()
            ->select('jenis_pemeriksaans.*') //biar ngga n+1 query
            ->join('modalitass', 'modalitass.id', '=', 'jenis_pemeriksaans.modalitas_id')
            ->with('modalitas');
            

        if ($search !== '') {
                $searchLower = strtolower($search);

                $query->where(function ($q) use ($search, $searchLower) {
                    $q->whereHas('modalitas', function ($mq) use ($search) {
                        $mq->where('namaModalitas', 'like', "%{$search}%");
                })
                ->orWhere('namaJenisPemeriksaan', 'like', "%{$search}%")
                ->orWhere('namaPemeriksaanSpesifik', 'like', "%{$search}%")
                ->orWhere('kelompokJenisPemeriksaan', 'like', "%{$search}%");
                if (is_numeric($search)) {
                    $q->orWhere('lamaPemeriksaan', $search);
                }
                if (in_array($searchLower, ['Ya', 'ya'])) {
                    $q->orWhere('pemakaianKontras', true)
                    ->orWhere('diDampingiDokter', true);
                } elseif (in_array($searchLower, ['Tidak', 'tidak'])) {
                    $q->orWhere('pemakaianKontras', false)
                    ->orWhere('diDampingiDokter', false);
                }
            });
        }
        
        $jenisPemeriksaans = $query
        // $rumahSakit->jenisPemeriksaan()
        //     ->with('modalitas')
        //     ->when($request->search, function ($query, $search) {
        //         $query->whereHas('modalitas', function ($q) use ($search){
        //             $q->where('namaModalitas', 'like', "%{$search}%");
        //         })
        //         ->orWhere('namaJenisPemeriksaan', 'like', "%{$search}%")
        //         ->orWhere('namaPemeriksaanSpesifik', 'like', "%{$search}%")
        //         ->orWhere('kelompokJenisPemeriksaan', 'like', "%{$search}%");
        //     })
            ->reorder() //buat reset semua order by
            ->orderBy('modalitass.namaModalitas', 'asc')   // harus pakai nama tabel
            ->orderBy('namaJenisPemeriksaan', 'asc') 
            ->paginate(10)
            ->withQueryString();

        return view('petugas.kelolajenispemeriksaan', [
            'petugas'           => $petugas,
            'jenisPemeriksaans' => $jenisPemeriksaans,
        ]);
    }
}
