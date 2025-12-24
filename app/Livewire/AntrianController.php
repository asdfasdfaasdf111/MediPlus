<?php

namespace App\Livewire;

use App\Models\RumahSakit;
use Livewire\Component;

class AntrianController extends Component
{
    public $rumahSakit;
    public $selectedModalitasId = null;

    public function mount($rumahSakit)
    {
        $this->rumahSakit = $rumahSakit;
    }

    public function lanjutAntrian($kelompokJenisPemeriksaanId)
    {
        if ($this->selectedModalitasId === null) return;

        $dataSekarang = $this->rumahSakit->dataDalamPemeriksaan($kelompokJenisPemeriksaanId)
                            ->where('modalitas_id', $this->selectedModalitasId)->first();
        
        if($dataSekarang){
            $dataSekarang->statusPasien = 'Menunggu Hasil';
            $dataSekarang->statusPetugas = 'Menunggu Laporan';
            $dataSekarang->statusDokter = 'Menunggu Laporan';
            $dataSekarang->save();
        }

        $dataBerikutnya = $this->rumahSakit->dataDalamAntrian($kelompokJenisPemeriksaanId)->first();
        if($dataBerikutnya){
            $dataBerikutnya->statusPasien = 'Pemeriksaan Berlangsung';
            $dataBerikutnya->statusPetugas = 'Pemeriksaan Berlangsung';
            $dataBerikutnya->statusDokter = 'Pemeriksaan Berlangsung';
            $dataBerikutnya->modalitas_id = $this->selectedModalitasId;
            $dataBerikutnya->save();
        }
        $this->selectedModalitasId = null;
    }

    public function selesaiPemeriksaanSekarang($kelompokJenisPemeriksaanId, $dataPemeriksaanId){
        $dataSekarang = $this->rumahSakit->dataDalamPemeriksaan($kelompokJenisPemeriksaanId)
                            ->where('id', $dataPemeriksaanId)->first();

        if($dataSekarang){
            $dataSekarang->statusPasien = 'Menunggu Hasil';
            $dataSekarang->statusPetugas = 'Menunggu Laporan';
            $dataSekarang->statusDokter = 'Menunggu Laporan';
            $dataSekarang->save();
        }
    }

    public function pilihModalitas($modalitasId)
    {
        $this->selectedModalitasId = $modalitasId;
    }

    public function render()
    {
        return view('livewire.antrian-controller');
    }
}
