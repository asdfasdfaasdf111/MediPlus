<div class="container-fluid py-4">

  <div class="row g-3">
    @foreach ($rumahSakit->namaJenisPemeriksaan() as $namaJenisPemeriksaan)
        @if ($rumahSakit->counterHariIni($namaJenisPemeriksaan) === null)
            @continue
        @endif

        @php
          $dataSekarang = $rumahSakit->dataDalamPemeriksaan($namaJenisPemeriksaan);
          $dataAntrian = $rumahSakit->dataDalamAntrian($namaJenisPemeriksaan)->get();
        @endphp

        <div class="col-12 col-lg-6">
          <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pb-0">
              <div class="d-flex align-items-start justify-content-between gap-2 mt-3">
                <div>
                  <div class="d-flex align-items-center gap-2 flex-wrap">
                    <h5 class="mb-0 fw-bold" style="color:#012970;">
                      {{ $namaJenisPemeriksaan }}
                    </h5>
                  </div>
                </div>

                <div class="text-end">
                  <span class="badge rounded-pill bg-light text-dark border">
                    <i class="bi bi-people me-1"></i>
                    {{ ($dataSekarang ? 1 : 0) + $dataAntrian->count() }} pasien
                  </span>
                </div>
              </div>
            </div>

            <div class="card-body pt-3">
              {{-- Pemeriksaan Berlangsung --}}
              <div class="p-3 rounded-3 border bg-white mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                  <div class="fw-semibold">
                    <i class="bi bi-activity me-1 text-primary"></i> Pemeriksaan Berlangsung
                  </div>

                  @if($dataSekarang === null)
                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                      Tidak ada pemeriksaan
                    </span>
                  @else
                    <span class="badge bg-success-subtle text-success border border-success-subtle">
                      Sedang berjalan
                    </span>
                  @endif
                </div>

                @if($dataSekarang === null)
                  <div class="text-muted">-</div>
                @else
                  @php 
                    $dataPasienSekarang = $dataSekarang->dataPasien; 
                  @endphp
                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div class="d-flex align-items-center gap-2">
                      <span class="badge bg-primary">
                        {{ $namaJenisPemeriksaan.'-'.$dataSekarang->nomorAntrian }}
                      </span>
                      <span class="fw-semibold">
                        {{ $dataPasienSekarang->namaLengkap ?? '-' }}
                      </span>
                    </div>

                    <button
                      wire:click="selesaiPemeriksaanSekarang('{{ $namaJenisPemeriksaan }}')"
                      class="btn btn-success btn-sm px-3"
                    >
                      <i class="bi bi-check2-circle me-1"></i> Selesaikan
                    </button>
                  </div>
                @endif
              </div>

              {{-- Dalam Antrian --}}
              <div class="p-3 rounded-3 border bg-light">


                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                  <div class="fw-semibold">
                    <i class="bi bi-hourglass-split me-1 text-warning"></i> Dalam Antrian
                  </div>
                  <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                    {{ $dataAntrian->count() }} antrian
                  </span>
                </div>

                @if($dataAntrian->isEmpty())
                  <div class="text-muted">-</div>
                @else
                  <ul class="list-group list-group-flush mb-3">
                    @foreach($dataAntrian as $dataPemeriksaan)
                      @php 
                        $dataPasien = $dataPemeriksaan->dataPasien; 
                      @endphp

                      <li class="list-group-item px-0 d-flex align-items-center justify-content-between bg-light">
                        <div class="d-flex align-items-center gap-2">
                          <i class="bi bi-person-badge text-muted"></i>
                          <span class="fw-semibold">{{ $namaJenisPemeriksaan }} - {{ $dataPemeriksaan->nomorAntrian }}</span>
                        </div>
                        <small class="text-muted">
                          {{ $dataPasien->namaLengkap ?? '-' }}
                        </small>
                        <span class="badge rounded-pill bg-light text-dark border">Queue</span>
                      </li>
                    @endforeach
                  </ul>

                  <div class="d-flex justify-content-end">
                    <button
                      wire:click="lanjutAntrian('{{ $namaJenisPemeriksaan }}')"
                      class="btn btn-primary btn-sm px-3"
                    >
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
