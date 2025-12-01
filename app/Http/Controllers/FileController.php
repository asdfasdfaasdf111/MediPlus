<?php

namespace App\Http\Controllers;

use App\Models\HasilPemeriksaan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FileController extends Controller
{
    public function index(): View {
        return view('dokter.hasilpemeriksaan');
    }

    public function store(Request $request, HasilPemeriksaan $hasilPemeriksaan) {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'dokter_id' => 'required|exists:dokters,id',
            'data_pemeriksaan_id' => 'required|exists:datapemeriksaans,id',
            'data_pasien_id' => 'required|exists:datapasiens,id'
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        $hasil = HasilPemeriksaan::create([
            'data_pemeriksaan_id' => $request->data_pemeriksaan_id,
            'data_pasien_id' => $request->data_pasien_id,
            'dokter_id' => $request->dokter_id,
            'file' => $path,
            'fileLampiran' => $request->file('file')->getClientOriginalName()
        ]);

        return back()->with('success', 'File uploaded successfully!')->with('file', $hasil->fileLampiran);
    }
}
