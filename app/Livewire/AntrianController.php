<?php

namespace App\Livewire;

use App\Models\RumahSakit;
use Livewire\Component;

class AntrianController extends Component
{
    public $rumahSakit;

    public function mount($rumahSakit)
    {
        $this->rumahSakit = $rumahSakit;
    }

    public function lanjutAntrian($namaJenisPemeriksaan)
    {
        $dataSekarang = $this->rumahSakit->dataDalamPemeriksaan($namaJenisPemeriksaan);

        if($dataSekarang){
            $dataSekarang->statusPasien = 'Menunggu Hasil';
            $dataSekarang->statusPetugas = 'Menunggu Laporan';
            $dataSekarang->statusDokter = 'Menunggu Laporan';
            $dataSekarang->save();
        }

        $dataBerikutnya = $this->rumahSakit->dataDalamAntrian($namaJenisPemeriksaan)->first();
        if($dataBerikutnya){
            $dataBerikutnya->statusPasien = 'Pemeriksaan Berlangsung';
            $dataBerikutnya->statusPetugas = 'Pemeriksaan Berlangsung';
            $dataBerikutnya->statusDokter = 'Pemeriksaan Berlangsung';
            $dataBerikutnya->save();
        }

    }

    public function selesaiPemeriksaanSekarang($namaJenisPemeriksaan){
        $dataSekarang = $this->rumahSakit->dataDalamPemeriksaan($namaJenisPemeriksaan);

        if($dataSekarang){
            $dataSekarang->statusPasien = 'Menunggu Hasil';
            $dataSekarang->statusPetugas = 'Menunggu Laporan';
            $dataSekarang->statusDokter = 'Menunggu Laporan';
            $dataSekarang->save();
        }
    }

    public function render()
    {
        return view('livewire.antrian-controller');
    }
}
