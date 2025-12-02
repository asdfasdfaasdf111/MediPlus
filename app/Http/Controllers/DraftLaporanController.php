<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\DraftLaporan;
use Illuminate\Http\Request;

class DraftLaporanController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');

        $drafts = DraftLaporan::when($search, function ($query, $search){
            $query->where('judul', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%");
        })
        ->orderBy('judul')
        ->get();

        return view('dokter.listdaftar', compact('drafts', 'search'));
    }

    public function editData(DraftLaporan $draft){
        return view('dokter.edit', compact('draft'));
    }

    public function updateDraft(Request $request, $id){
        $draft = DraftLaporan::findOrFail($id);

        $request->validate([
            'judul' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $draft->update([
            'judul' => $request->judul ?? $draft->judul,
            'deskripsi' => $request->deskripsi ?? $draft->deskripsi
        ]);

        return redirect('/dokter/listdraft')->with('success', 'Data berhasil diupdate');
    }

    public function addNew(){
        return view('dokter.addnew');
    }

    public function store(Request $request){
        $request->validate([
            'judul' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string'
        ]);

        $rumahSakit = DraftLaporan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'dokter_id' => auth()->id()
        ]);

        return redirect(route('dokter.listdaftar'))->with('success', 'Draft berhasil ditambahkan.');
    }

        public function deleteData(DraftLaporan $draft){
        $draft->delete();
        return redirect()->route('dokter.listdaftar')->with('success', 'Data berhasil dihapus');
    }

}
