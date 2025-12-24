<div>
    @foreach ($rumahSakit->kelompokJenisPemeriksaan as $kelompokJenisPemeriksaan)
        @if ($rumahSakit->counterHariIni($kelompokJenisPemeriksaan->id) === null)
            @continue
        @endif

        @php
          $dataSekarang = $rumahSakit->dataDalamPemeriksaan($kelompokJenisPemeriksaan->id)->get();
          $dataAntrian = $rumahSakit->dataDalamAntrian($kelompokJenisPemeriksaan->id)->get();
          $modalitass = $kelompokJenisPemeriksaan->modalitas;
        @endphp

        <div>
            <div>
                {{ $kelompokJenisPemeriksaan->namaKelompok }}
            </div>
          <div>
            Sekarang: 
            @if($dataSekarang->isEmpty())
                -
            @else
              @foreach ($dataSekarang as $data)
                <div>
                  {{ $kelompokJenisPemeriksaan->namaKelompok.'-'.$data->nomorAntrian }}
                  Modalitas: {{ $data->modalitas->namaModalitas }} - {{ $data->modalitas->kodeRuang }}
                  <button wire:click="selesaiPemeriksaanSekarang({{ $kelompokJenisPemeriksaan->id }}, {{ $data->id }})" class="btn btn-primary">
                    Selesaikan Pemeriksaan Sekarang
                  </button>
                </div>
              @endforeach
            @endif
            </div>
          <div>
            Menunggu Antrian: 
            
            @if($dataAntrian->isEmpty())
                -
            @else
                @foreach($dataAntrian as $dataPemeriksaan)
                  {{ $kelompokJenisPemeriksaan->namaKelompok }}-{{ $dataPemeriksaan->nomorAntrian }}
                @endforeach
                <button wire:click="lanjutAntrian('{{ $kelompokJenisPemeriksaan->id }}')" class="btn btn-primary">
                  Lanjut Antrian Berikutnya
                </button>
                <div>
                  Pilih Modalitas:
                  <div>
                    @foreach ($modalitass as $modalitas)
                      <button wire:click="pilihModalitas('{{ $modalitas->id }}')" 
                        class="btn {{ $selectedModalitasId == $modalitas->id ? 'btn-success' : 'btn-primary' }}">
                        {{$modalitas->namaModalitas}} - {{ $modalitas->kodeRuang }}
                      </button>
                    @endforeach
                  </div>
                </div>
            @endif
          </div>
        </div>
        <div>=============================================================</div>
    @endforeach
</div>
