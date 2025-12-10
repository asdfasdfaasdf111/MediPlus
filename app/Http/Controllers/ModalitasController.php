<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modalitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModalitasController extends Controller
{
    public function tambahModalitas(Request $request){
        $request->validate([
            'namaModalitas' => 'required|string|max:100',
            'jenisModalitas' => 'required|string|max:100',
            'kodeRuang' => 'required|string|max:100',
        ],
        [
            'namaModalitas.required' => 'Nama Modalitas wajib diisi.',
            'jenisModalitas.required' => 'Jenis Modalitas wajib diisi.',
            'kodeRuang.required' => 'Kode Ruang wajib diisi.',
            
        ]
    );

        Modalitas::create([
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'namaModalitas' => $request->namaModalitas,
            'jenisModalitas' => $request->jenisModalitas,
            'kodeRuang' => $request->kodeRuang,
        ]);

        return redirect()->route('petugas.kelolamodalitas')->with('success', 'Berhasil menambahkan Modalitas!');
    }

    public function editModalitas(Request $request, $id){
        $modalitas = Modalitas::findOrFail($id);

        $request->validate([
            'namaModalitas' => 'required|string|max:100',
            'jenisModalitas' => 'required|string|max:100',
            'kodeRuang' => 'required|string|max:100',
        ],
        [
            'namaModalitas.required'  => 'Nama Modalitas wajib diisi.',
            'jenisModalitas.required' => 'Jenis Modalitas wajib diisi.',
            'kodeRuang.required'      => 'Kode Ruang wajib diisi.',
        ]);

        $modalitas->namaModalitas = $request->input('namaModalitas');
        $modalitas->jenisModalitas = $request->input('jenisModalitas');
        $modalitas->kodeRuang = $request->input('kodeRuang');

        $modalitas->save();

        return response()->json([
            'success' => true,
            ]);
    }

    public function hapusModalitas($id){
        $modalitas = Modalitas::findOrFail($id);
        $modalitas->delete();
    
        return redirect()->back()->with('success', 'Berhasil menghapus Modalitas!');
    }

    public function tampilkanModalitas(Request $request)
    {
        $petugas = auth()->user()->petugas;
        $rumahSakit = $petugas->rumahSakit;

        // buat nge trim spasi di awal dan akhir
        $search = trim($request->search ?? '');

        $query = $rumahSakit->modalitas();   // relasi modalitas punya RS ini
        
       if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('namaModalitas', 'like', "%{$search}%")
                ->orWhere('jenisModalitas', 'like', "%{$search}%")
                ->orWhere('kodeRuang', 'like', "%{$search}%");

            });
        }

        $modalitass = $query
        ->orderBy('namaModalitas')
        ->paginate(10)         
        ->withQueryString();   

        return view('petugas.kelolamodalitas', [
            'petugas'    => $petugas,
            'modalitass' => $modalitass,
        ]);
        
    }
}
