<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pendaftaran Pemeriksaan</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
    use Carbon\Carbon;
    $dataPemeriksaan = $masterPasien->draftPemeriksaan;
    $dataRujukan = $dataPemeriksaan->dataRujukan;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dataPasien = $dataPemeriksaan->dataPasien;
@endphp

<body class="bg-light text-dark">
  <div class="container-fluid py-3 py-md-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 min-vh-100 d-flex flex-column">

        {{-- FEnya ngikut template petugas pratinjau pemeriksaan --}}
        <div class="mb-3">
          <h4 class="mb-1" style="color:#173B7A; ">Ringkasan Pendaftaran</h4>
          <div class="text-muted small">
            Berikut adalah pratinjau pendaftaran pemeriksaan Anda. Pastikan seluruh data sudah sesuai sebelum melanjutkan.
          </div>
        </div>

        <div class="row g-3">

          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                <div>
                  <i class="bi bi-calendar2-week me-2"></i> Pilih Jadwal
                </div>
                <a href="{{ route('pasien.daftarpilihjadwal') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                  Ubah Jadwal
                </a>
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


          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                <div>
                  <i class="bi bi-people me-2"></i> Tipe Pasien
                </div>
                <a href="{{ route('pasien.daftartipepasien') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                  Ubah Tipe Pasien
                </a>
              </div>
              <div class="card-body">
                <div class="vstack gap-3">
                  <div>
                    <div class="small text-muted">Nama Pasien</div>
                    <div class="fw-semibold">
                      {{ $dataPasien->namaLengkap }}
                    </div>
                  </div>

                  <div>
                    <div class="small text-muted">Hubungan dengan Pasien</div>
                    <div class="fw-semibold">
                      {{ $dataPemeriksaan->hubunganPendamping }}
                    </div>
                  </div>

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


                  <div class="col-12 col-lg-6">
                    <div class="mb-3">
                      <div class="small text-muted">Jenis Kartu Identitas</div>
                      <div class="fw-semibold">{{ $dataPasien->jenisIdentitas }}</div>
                    </div>

                    <div class="mb-3">
                      <div class="small text-muted">Nomor Identitas</div>
                      <div class="fw-semibold">{{ $dataPasien->noIdentitas }}</div>
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


          <div class="col-12">
            <div class="card shadow-sm">
              <div class="card-header d-flex justify-content-between align-items-center fw-semibold">
                <div>
                  <i class="bi bi-hospital me-2"></i> Data Rujukan
                </div>
                <a href="{{ route('pasien.daftardatarujukan') }}" class="btn btn-outline-primary btn-sm rounded-pill">
                  Ubah Data Rujukan
                </a>
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

        </div> 


        
        <form method="POST" action="{{ route('pasien.finalisasiDraft', $dataPemeriksaan) }}" class="mt-4">
            @csrf
            @method('PUT')

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('pasien.daftardatarujukan') }}"  class="btn btn-outline-primary px-5 rounded-pill">
                   Kembali
                </a>
                <button id="submitBtn" type="submit" class="btn btn-primary px-5 rounded-pill">
                    Daftar
                </button>
            </div>
        </form>

      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
