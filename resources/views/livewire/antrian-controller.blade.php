<div>
    @foreach ($rumahSakit->namaJenisPemeriksaan() as $namaJenisPemeriksaan)
        @if ($rumahSakit->counterHariIni($namaJenisPemeriksaan) === null)
            @continue
        @endif

        @php
          $dataSekarang = $rumahSakit->dataDalamPemeriksaan($namaJenisPemeriksaan);
          $dataAntrian = $rumahSakit->dataDalamAntrian($namaJenisPemeriksaan)->get();
        @endphp

        <div>
            <div>
                {{ $namaJenisPemeriksaan }}
            </div>
          <div>
            Sekarang: 
            @if($dataSekarang === null)
                -
            @else
                {{ $namaJenisPemeriksaan.'-'.$dataSekarang->nomorAntrian }}
                <button wire:click="selesaiPemeriksaanSekarang('{{ $namaJenisPemeriksaan }}')" class="btn btn-primary">
                  Selesaikan Pemeriksaan Sekarang
                </button>
            @endif
            </div>
          <div>
            Menunggu Antrian: 
            
            @if($dataAntrian->isEmpty())
                -
            @else
                @foreach($dataAntrian as $dataPemeriksaan)
                  {{ $namaJenisPemeriksaan }} - {{ $dataPemeriksaan->nomorAntrian }}
                @endforeach
                <button wire:click="lanjutAntrian('{{ $namaJenisPemeriksaan }}')" class="btn btn-primary">
                  Lanjut Antrian Berikutnya
                </button>
            @endif
          </div>
        </div>
        <div>=============================================================</div>
    @endforeach
</div>
