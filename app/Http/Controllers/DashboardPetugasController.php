<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardPetugasController extends Controller
{
    public function tampilkanDashboard(Request $request)
    {
        $petugas = auth()->user()->petugas;

        $aktif = $request->input('status', 'semua');
        $search = $request->input('search');

        $query = $petugas->dataPemeriksaan()->with('dataPasien', 'dataRujukan', 'jenisPemeriksaan', 'dokter.user');
        //dokter.user = load relasi dokter, dan di dalamnya load relasi user 

        // Filter status tab jadinya dipindahin ke controller, katanya sih jd di view gada ngurus logic lagi
        if ($aktif !== 'semua') {
        $statusMap = [
            'pending'     => 'Pending',
            'berlangsung' => 'Berlangsung',
            'selesai'     => 'Selesai',
            'dibatalkan'  => 'Dibatalkan',
        ];

        if (isset($statusMap[$aktif])) {
            $query->where('statusUtama', $statusMap[$aktif]);
        }
    }

    $query->when($search, function ($q, $search) {
            $search = trim($search); // Hapus spasi di awal dan akhir

            $q->where(function ($sub) use ($search) {
                    // $sub->where('noRegistrasi', 'like', "%{$search}%") //Ini no reg gimana cara searchnya hehe

                    // Kalo search nama pasien
                    $sub->whereHas('dataPasien', function ($q2) use ($search) {
                        $q2->where('namaLengkap', 'like', "%{$search}%");
                    })
                    // dokter perujuk
                    ->orWhereHas('dataRujukan', function ($q2) use ($search) {
                        $q2->where('namaDokterPerujuk', 'like', "%{$search}%");
                    })
                    // jenis pemeriksaan + spesifik
                    ->orWhereHas('jenisPemeriksaan', function ($q2) use ($search) {
                        $q2->where('namaJenisPemeriksaan', 'like', "%{$search}%")
                           ->orWhere('namaPemeriksaanSpesifik', 'like', "%{$search}%");
                    })
                    // dokter radiologi
                    ->orWhereHas('dokter.user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        });

         $dataPemeriksaans = $query
            ->orderBy('created_at', 'desc')
            ->get();

        // ini katanya biar  di view tetap bisa pakai $petugas->dataPemeriksaan
        $petugas->setRelation('dataPemeriksaan', $dataPemeriksaans);

        
        return view('petugas.dashboard', [
            'petugas' => $petugas,
            'aktif'   => $aktif,    
        ]);
    }
        
}
