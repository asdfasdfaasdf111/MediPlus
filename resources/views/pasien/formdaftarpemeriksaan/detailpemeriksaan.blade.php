@extends('layout.app')

@section('title', 'Lihat Detail Pemeriksaan Pasien')

@section('content')

@php
    use Carbon\Carbon;
    $rumahSakit       = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dokter           = $dataPemeriksaan->dokter;
    $dataPasien       = $dataPemeriksaan->dataPasien;
    $dataRujukan      = $dataPemeriksaan->dataRujukan;
@endphp

<body class="bg-light text-dark">
  <div class="container-fluid py-3 py-md-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 min-vh-100 d-flex flex-column">

        {{-- Header --}}
        <div class="mb-3">
          <h4 class="mb-1" style="color:#173B7A;">Detail Pemeriksaan</h4>
          <div class="text-muted small">
            Berikut terlampir ringkasan pemeriksaan radiologi beserta riwayat perubahan oleh petugas.
          </div>
        </div>

        <div class="row g-3">

          {{-- Ini kalau ada perubahan oleh petugas baru ketampil --}}
          @if (!empty($dataPemeriksaan->historyJenisPemeriksaan))
            <div class="col-12">
              <div class="card shadow-sm border-primary">
                {{--  bg-warning-subtle ini buat jadi kuning --}}
                <div class="card-header bg-primary-subtle fw-semibold d-flex align-items-center"> 
                  <i class="bi bi-clock-history me-2"></i>
                  Detail Perubahan
                </div>
                <div class="card-body">
                  <div class="vstack gap-3">

                    @if ($dataPemeriksaan->historyJenisPemeriksaan != $dataPemeriksaan->jenis_pemeriksaan_id)
                      @php
                        $jenisLama = \App\Models\JenisPemeriksaan::find($dataPemeriksaan->historyJenisPemeriksaan);
                      @endphp
                      <div>
                        <div class="small text-muted mb-1">Jenis Pemeriksaan</div>
                        <div class="row g-2">
                          <div class="col-md-6">
                            <div class="small text-muted">Data Sebelum</div>
                            <div class="fw-semibold">
                              {{ $jenisLama->namaJenisPemeriksaan }} - {{ $jenisLama->namaPemeriksaanSpesifik }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="small text-muted">Data Setelah</div>
                            <div class="fw-semibold">
                              {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif

                    @if ($dataPemeriksaan->historyTanggalPemeriksaan != $dataPemeriksaan->tanggalPemeriksaan)
                      <div>
                        <div class="small text-muted mb-1">Tanggal Pemeriksaan</div>
                        <div class="row g-2">
                          <div class="col-md-6">
                            <div class="small text-muted">Data Sebelum</div>
                            <div class="fw-semibold">
                              {{ $dataPemeriksaan->historyTanggalPemeriksaan }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="small text-muted">Data Setelah</div>
                            <div class="fw-semibold">
                              {{ $dataPemeriksaan->tanggalPemeriksaan }}
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif

                    @if ($dataPemeriksaan->historyJamPemeriksaan != $dataPemeriksaan->rentangWaktuKedatangan)
                      <div>
                        <div class="small text-muted mb-1">Jam Pemeriksaan</div>
                        <div class="row g-2">
                          <div class="col-md-6">
                            <div class="small text-muted">Data Sebelum</div>
                            <div class="fw-semibold">
                              {{ $dataPemeriksaan->historyJamPemeriksaan }}
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="small text-muted">Data Setelah</div>
                            <div class="fw-semibold">
                              {{ $dataPemeriksaan->rentangWaktuKedatangan }}
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif

                    <div>
                      <div class="small text-muted mb-1">Catatan Petugas</div>
                      <div class="fw-semibold text-break">
                        {{ $dataPemeriksaan->catatanPetugas }}
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          @endif


          {{-- PILIH JADWAL --}}
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                <div>
                  <i class="bi bi-calendar2-week me-2"></i> Pilih Jadwal
                </div>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="small text-muted">Rumah Sakit</div>
                    <div class="fw-semibold">
                      {{ $rumahSakit->nama }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted">Jenis Pemeriksaan</div>
                    <div class="fw-semibold">
                      {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}
                    </div>
                  </div>

                  @if ($dokter != null)
                    <div class="col-md-6">
                      <div class="small text-muted">Dokter Radiologi</div>
                      <div class="fw-semibold">
                        {{ $dokter->user->name }}
                      </div>
                    </div>
                  @endif

                  <div class="col-md-6">
                    <div class="small text-muted">Tanggal Pemeriksaan</div>
                    <div class="fw-semibold">
                      {{ $dataPemeriksaan->tanggalPemeriksaan }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted">Rentang Waktu Kedatangan</div>
                    <div class="fw-semibold">
                      {{ $dataPemeriksaan->rentangWaktuKedatangan }}
                      -
                      {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          {{-- TIPE PASIEN --}}
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header fw-semibold">
                <i class="bi bi-people me-2"></i> Tipe Pasien
              </div>
              <div class="card-body">
                <div class="vstack gap-3">

                  {{-- yang di comment itu antara uda ga diperlukan(kayanya, bahas dlu), atau datanya ga disimpan --}}
                  {{-- 
                  <div>
                    <div class="small text-muted">Tipe Pasien</div>
                    <div class="fw-semibold">...</div>
                  </div>
                  --}}

                  <div>
                    <div class="small text-muted">Nama Pendamping</div>
                    <div class="fw-semibold">
                      @if (!empty($dataPemeriksaan->namaPendamping))
                        {{ $dataPemeriksaan->namaPendamping }}
                      @else
                        -
                      @endif
                    </div>
                  </div>

                  <div>
                    <div class="small text-muted">Nomor Telepon Pendamping</div>
                    <div class="fw-semibold">
                      @if (!empty($dataPemeriksaan->nomorPendamping))
                        {{ $dataPemeriksaan->nomorPendamping }}
                      @else
                        -
                      @endif
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


          {{-- FORMULIR DATA DIRI --}}
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header fw-semibold">
                <i class="bi bi-person-vcard me-2"></i> Formulir Data Diri
              </div>
              <div class="card-body">
                <div class="row g-4">

                  {{-- KIRI --}}
                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Nama Lengkap</div>
                      <div class="fw-semibold">{{ $dataPasien->namaLengkap }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Jenis Kelamin</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatJenisKelamin }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Tanggal Lahir</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatTanggalLahir }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Golongan Darah</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatGolonganDarah }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Nomor Telepon Aktif</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatNoHP }}</div>
                    </div>
                  </div>

                  {{-- KANAN --}}
                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Jenis Kartu Identitas</div>
                      <div class="fw-semibold">{{ $dataPasien->jenisIdentitas }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Nomor Identitas</div>
                      <div class="fw-semibold">
                        @php
                            $start = substr($dataPasien->noIdentitas, 0, 4);
                            for ($i = 0; $i < strlen($dataPasien->noIdentitas) - 4; $i++){
                                $start .= 'X';
                            }
                        @endphp
                        {{ $start }}
                      </div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Alamat Domisili</div>
                      <div class="fw-semibold text-break">
                        {{ $dataPemeriksaan->riwayatAlamatDomisili }}
                      </div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Apakah Pasien memiliki Alergi</div>
                      <div class="fw-semibold">
                        @if (!empty($dataPemeriksaan->riwayatAlergi))
                          Ya
                        @else
                          Tidak
                        @endif
                      </div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Deskripsi Alergi</div>
                      <div class="fw-semibold text-break">
                        @if (!empty($dataPemeriksaan->riwayatAlergi))
                          {{ $dataPemeriksaan->riwayatAlergi }}
                        @else
                          -
                        @endif
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>


          {{-- DATA RUJUKAN --}}
          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header fw-semibold">
                <i class="bi bi-hospital me-2"></i> Data Rujukan
              </div>
              <div class="card-body">
                <div class="row g-4">

                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Nama Fasilitas Kesehatan</div>
                      <div class="fw-semibold">{{ $dataRujukan->namaFaskes }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Nama Dokter Perujuk</div>
                      <div class="fw-semibold">{{ $dataRujukan->namaDokterPerujuk }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Tanggal Pemeriksaan di Klinik</div>
                      <div class="fw-semibold">{{ $dataRujukan->tanggalPemeriksaanFaskes }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Diagnosa Kerja</div>
                      <div class="fw-semibold text-break">{{ $dataRujukan->diagnosaKerja }}</div>
                    </div>
                  </div>

                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Alasan Rujukan</div>
                      <div class="fw-semibold text-break">{{ $dataRujukan->alasanRujukan }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Permintaan Pemeriksaan</div>
                      <div class="fw-semibold text-break">{{ $dataRujukan->permintaanPemeriksaan }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Formulir Rujukan</div>
                      <div class="fw-semibold text-break">
                        <a href="{{ asset('storage/' . $dataRujukan->formulirRujukan) }}" target="_blank">
                          {{ $dataRujukan->namaFile }}
                        </a>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>

        </div> {{-- end row g-3 --}}

        {{-- BUTTON KEMBALI --}}
        <div class="mt-4 d-flex justify-content-center">
          <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-outline-primary px-5 rounded-pill">
            Kembali
          </a>
        </div>

      </div>
    </div>
  </div>

  {{-- <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html> --}}
@endsection