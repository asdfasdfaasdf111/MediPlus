<div class="container-fluid py-4">
  <div class="row g-4">

    @foreach ($rumahSakit->kelompokJenisPemeriksaan as $kelompok)
      @if ($rumahSakit->counterHariIni($kelompok->id) === null)
        @continue
      @endif

      @php
        $dataSekarang = $rumahSakit->dataDalamPemeriksaan($kelompok->id)->get();
        $dataAntrian  = $rumahSakit->dataDalamAntrian($kelompok->id)->get();
        $modalitass   = $kelompok->modalitas;
      @endphp

      <div class="col-12 col-md-6 mb-4">
        <div class="card border-0 shadow-sm h-100">

          <div class="card-header bg-white border-0 pb-0 ">
            <div class="d-flex justify-content-between mt-3">
              <h5 class="fw-bold" style="color:#012970;">
                {{ $kelompok->namaKelompok }}
              </h5>

              <div class="text-center">
                <span class="badge rounded-pill bg-light text-dark border">
                  <i class="bi bi-people me-1"></i>
                  {{ $dataSekarang->count() + $dataAntrian->count() }} pasien
                </span>
              </div>
            </div>
          </div>

        
          <div class="card-body pt-3">

            {{-- PEMERIKSAAN BERLANGSUNG --}}
              <div class="d-flex justify-content-between mb-2">
                <div class="fw-semibold">

                  Pemeriksaan Berlangsung
                </div>
              </div>

              @if($dataSekarang->isEmpty())
                <div class="text-muted">-</div>
              @else
                <ul class="list-group list-group-flush">
                  @foreach ($dataSekarang as $data)
                    <li class="list-group-item px-0 bg-white">
                      <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                        <div>
                          <span class="badge bg-primary me-1">
                            Antrian {{ $data->nomorAntrian }} - {{ $data->jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $data->dataPasien->namaLengkap ?? '-' }}
                          </span>

                          <div class="small text-muted">
                            ({{ $data->modalitas->kodeRuang }}) - {{ $data->modalitas->namaModalitas }}

                          </div>
                        </div>

                        <button wire:click="selesaiPemeriksaanSekarang('{{ $kelompok->id }}','{{ $data->id }}')" class="btn btn-sm btn-success">
                          <i class="bi bi-check2-circle me-1"></i>
                          Selesaikan
                        </button>

                      </div>
                    </li>
                  @endforeach
                </ul>
              @endif

            {{-- DALAM ANTRIAN --}}
            <div class="p-3 rounded-3 border bg-light">
              <div class="d-flex justify-content-between mb-2">
                <div class="fw-semibold">
                  Dalam Antrian
                </div>
                <span class="badge bg-warning-subtle text-warning border">
                  {{ $dataAntrian->count() }} antrian
                </span>
              </div>

              @if($dataAntrian->isEmpty())
                <div class="text-muted">-</div>
              @else
                <ul class="list-group list-group-flush mb-3">
                  @foreach($dataAntrian as $antrian)
                    @php 
                      $dataPasien = $antrian->dataPasien; 
                    @endphp
                    <li class="list-group-item px-0 bg-light">
                     Antrian {{ $antrian->nomorAntrian }} - {{ $antrian->jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $dataPasien->namaLengkap ?? '-' }}
                    </li>
                  @endforeach
                </ul>

                {{-- PILIH MODALITAS --}}
                <div class="mb-3">
                  <small class="fw-semibold d-block mb-2">Pilih Modalitas untuk Antrian Teratas</small>
                  <div class="d-flex flex-wrap gap-2">
                    @foreach ($modalitass as $modalitas)
                      <button wire:click="pilihModalitas('{{ $modalitas->id }}')"class="btn btn-sm {{ $selectedModalitasId == $modalitas->id ? 'btn-success' : 'btn-outline-primary' }}">
                        {{ $modalitas->namaModalitas }} - {{ $modalitas->kodeRuang }}
                      </button>
                    @endforeach
                  </div>
                </div>

                <div class="d-flex justify-content-end">
                  <button wire:click="lanjutAntrian('{{ $kelompok->id }}')" class="btn btn-primary btn-sm px-3">
                    <i class="bi bi-skip-forward-circle me-1"></i> Lanjut Antrian Berikutnya
                  </button>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endforeach

  </div>
</div>
