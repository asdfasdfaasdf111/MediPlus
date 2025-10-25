<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Modalitas;
use Illuminate\Http\Request;

class ModalitasController extends Controller
{
    public function tambahModalitas(Request $request){
        $request->validate([
            'namaModalitas' => 'required|string|max:100',
            'jenisModalitas' => 'required|string|max:100',
            'kodeRuang' => 'required|string|max:100',
        ]);

        Modalitas::create([
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'namaModalitas' => $request->namaModalitas,
            'jenisModalitas' => $request->jenisModalitas,
            'kodeRuang' => $request->kodeRuang,
        ]);

        return redirect()->route('petugas.kelolamodalitas')->with('success', 'Modalitas berhasil dibuat!');
    }

    public function editModalitas(Request $request, $id){
        $modalitas = Modalitas::findOrFail($id);

        $request->validate([
            'namaModalitas' => 'required|string|max:100',
            'jenisModalitas' => 'required|string|max:100',
            'kodeRuang' => 'required|string|max:100',
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
    
        return redirect()->back()->with('success', 'Modalitas berhasil dihapus.');
    }

    public function tampilkanModalitas(Request $request)
    {
        $petugas = auth()->user()->petugas;
        $rumahSakit = $petugas->rumahSakit;
        
        $modalitass = $rumahSakit->modalitas()
        ->when($request->search, function ($query, $search) {
            $query->where('namaModalitas', 'like', "%{$search}%")
            ->orWhere('jenisModalitas', 'like', "%{$search}%");
        })
        ->get();
        
        return view('petugas.kelolamodalitas', compact('modalitass'));
    }
}
