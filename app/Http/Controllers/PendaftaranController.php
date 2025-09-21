<?php

namespace App\Http\Controllers;

use App\Models\JenisPemeriksaan;
use App\Models\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PendaftaranController extends Controller
{
    // STEP 1: Pilih Jadwal
    public function index(Request $request)
    {
        $rumahsakits = RumahSakit::orderBy('nama')->get(['id', 'nama', 'jamBuka', 'jamTutup', 'jumlahPasien']);
        
        $rsId = $request->query('rumah_sakit');
        $jenisId = $request->query('jenis_pemeriksaan');
        $spesifikId = $request->query('spesifik');
        $tanggal = $request->query('tanggal', now('Asia/Jakarta')->toDateString());

        $jenisList = collect();
        if ($rsId) {
            $jenisList = JenisPemeriksaan::where('rumah_sakit_id', $rsId)
            ->orderBy('namaJenisPemeriksaan')
            ->get(['id', 'namaJenisPemeriksaan']);
        }

        $spesifikList = collect();
        if ($jenisId) {
            $spesifikList = JenisPemeriksaan::where('id', $jenisId)
            ->whereNotNull('namaPemeriksaanSpesifik')
            ->pluck('namaPemeriksaanSpesifik', 'id');

        $slots = [];
        if ($rsId && $jenisId && $spesifikId && $tanggal)


        
        




}
