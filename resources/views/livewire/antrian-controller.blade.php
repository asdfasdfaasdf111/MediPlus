<div>
    @foreach ($rumahSakit->modalitas as $modalitas)
        @if ($rumahSakit->counterHariIni($modalitas->id) === null)
            @continue
        @endif

        @php
          $dataSekarang = $rumahSakit->dataDalamPemeriksaan($modalitas->id);
          $dataAntrian = $rumahSakit->dataDalamAntrian($modalitas->id)->get();
        @endphp

        <div>
            <div>
                {{ $modalitas->namaModalitas }}
            </div>
          <div>
            Sekarang: 
            @if($dataSekarang === null)
                -
            @else
                {{ $modalitas->namaModalitas.'-'.$dataSekarang->nomorAntrian }}
                <button wire:click="selesaiPemeriksaanSekarang('{{ $modalitas->id }}')" class="btn btn-primary">
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
                  {{ $modalitas->namaModalitas }} - {{ $dataPemeriksaan->nomorAntrian }}
                @endforeach
                <button wire:click="lanjutAntrian('{{ $modalitas->id }}')" class="btn btn-primary">
                  Lanjut Antrian Berikutnya
                </button>
            @endif
          </div>
        </div>
        <div>=============================================================</div>
    @endforeach
</div>
