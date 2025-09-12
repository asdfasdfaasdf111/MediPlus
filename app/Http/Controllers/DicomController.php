<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Dicom;
use App\Models\Modalitas;
use Illuminate\Http\Request;

class DicomController extends Controller
{
    public function tambahDicom(Request $request){
        $request->validate([
            'netMask' => 'required|string|max:100',
            'layananDicom' => 'required|string|max:100',
            'peran' => 'required|string|max:100',
            'AET' => 'required|string|max:100',
            'port' => 'required|integer|min:1',
        ]);

        $modalitas = Modalitas::findOrFail($request->modalitasId);

        Dicom::create([
            'modalitas_id' => $request->modalitasId,
            'rumah_sakit_id' => auth()->user()->petugas->rumahSakit->id,
            'alamatIP' => $modalitas->alamatIP,
            'netMask' => $request->netMask,
            'layananDicom' => $request->layananDicom,
            'peran' => $request->peran,
            'AET' => $request->AET,
            'port' => $request->port,
        ]);

        return redirect()->route('petugas.keloladicom')->with('success', 'DICOM berhasil dibuat!');
    }

    public function editDicom(Request $request, $id){
        $dicom = Dicom::findOrFail($id);
        
        $request->validate([
            'netMask' => 'required|string|max:100',
            'layananDicom' => 'required|string|max:100',
            'peran' => 'required|string|max:100',
            'AET' => 'required|string|max:100',
            'port' => 'required|integer|min:1',
        ]);

        $dicom->modalitas_id = $request->input('modalitasId');
        $modalitas = Modalitas::findOrFail($dicom->modalitas_id);
        $dicom->netMask = $request->input('netMask');
        $dicom->layananDicom = $request->input('layananDicom');
        $dicom->peran = $request->input('peran');
        $dicom->AET = $request->input('AET');
        $dicom->port = $request->input('port');

        $dicom->save();


        return response()->json([
            'success' => true,
            'alamatIP' => $modalitas->alamatIP,
            ]);
    }

    public function hapusDicom($id){
        $dicom = Dicom::findOrFail($id);
        $dicom->delete();
    
        return redirect()->back()->with('success', 'DICOM berhasil dihapus.');
    }
}
