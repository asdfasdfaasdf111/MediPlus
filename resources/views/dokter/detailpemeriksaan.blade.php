<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokter | Detail Pemeriksaan</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>

@php
    use Carbon\Carbon;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dokter = $dataPemeriksaan->dokter;
    $dataPasien = $dataPemeriksaan->dataPasien;
    $dataRujukan = $dataPemeriksaan->dataRujukan;
    $hasilPemeriksaan = $dataPemeriksaan->hasilPemeriksaan;
@endphp

<body class="bg-white text-dark">
    @include('layout.navbar2')
  <div class="container-fluid py-3 py-md-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 min-vh-100 d-flex flex-column">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h4 class="mb-1 fw-bold" style="color:#173B7A;">Detail Pemeriksaan</h4>
                <div class="text-muted small">
                  Ringkasan pemeriksaan, data pasien, dan data rujukan untuk bahan analisa dokter.
                </div>
            </div>
            <a href="{{ route('dokter.homepage') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>

        <div class="row g-3">

          <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header fw-semibold d-flex align-items-center">
                <i class="bi bi-calendar2-week me-2"></i>
                Ringkasan Pemeriksaan
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <div class="small text-muted">Rumah Sakit</div>
                    <div class="fw-semibold">{{ $rumahSakit->nama }}</div>
                  </div>
                  <div class="col-md-6">
                    <div class="small text-muted">Jenis Pemeriksaan</div>
                    <div class="fw-semibold">
                      {{ $jenisPemeriksaan->namaJenisPemeriksaan }} - {{ $jenisPemeriksaan->namaPemeriksaanSpesifik }}
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="small text-muted">Tanggal Pemeriksaan</div>
                    <div class="fw-semibold">{{ $dataPemeriksaan->tanggalPemeriksaan }}</div>
                  </div>
                  <div class="col-md-6">
                    <div class="small text-muted">Rentang Waktu Kedatangan</div>
                    <div class="fw-semibold">
                      {{ $dataPemeriksaan->rentangWaktuKedatangan }}
                      -
                      {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString() }}
                    </div>
                  </div>

                  @if ($dataPemeriksaan->statusUtama != 'Dibatalkan')
                    <div class="col-md-6">
                      <div class="small text-muted">Dokter Radiologi</div>
                      <div class="fw-semibold">{{ $dokter->user->name }}</div>
                    </div>
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- DATA PASIEN --}}
          <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header fw-semibold d-flex align-items-center">
                <i class="bi bi-person-vcard me-2"></i>
                Data Pasien
              </div>
              <div class="card-body">
                <div class="row g-4">
                  <div class="col-12 col-md-6">
                    <div class="mb-3">
                      <div class="small text-muted">Nama Lengkap</div>
                      <div class="fw-semibold">{{ $dataPasien->namaLengkap }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Jenis Kelamin</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatJenisKelamin }}</div>
                    </div>
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="mb-3">
                      <div class="small text-muted">Tanggal Lahir</div>
                      <div class="fw-semibold">{{ $dataPemeriksaan->riwayatTanggalLahir }}</div>
                    </div>

                    <div class="mb-0">
                      <div class="small text-muted">Deskripsi Alergi</div>
                      @if (!empty($dataPemeriksaan->riwayatAlergi))
                        <div class="fw-semibold text-break">{{ $dataPemeriksaan->riwayatAlergi }}</div>
                      @else
                        <div class="text-secondary">-</div>
                      @endif
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
              <div class="card-header fw-semibold d-flex align-items-center">
                <i class="bi bi-hospital me-2"></i>
                Data Rujukan
              </div>
              <div class="card-body">
                <div class="row g-4">

                  <div class="col-12 col-md-6">
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

                    <div class="mb-0">
                      <div class="small text-muted">Diagnosa Kerja</div>
                      <div class="fw-semibold text-break">{{ $dataRujukan->diagnosaKerja }}</div>
                    </div>
                  </div>


                  <div class="col-12 col-md-6">
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
                        {{ $dataRujukan->formulirRujukan }}
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>


          @if($dataPemeriksaan->statusDokter == 'Menunggu Laporan')
            <div class="col-12">
              <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-header fw-semibold d-flex align-items-center">
                  <i class="bi bi-file-earmark-arrow-up me-2"></i>
                  Unggah Hasil Pemeriksaan
                </div>

                <div class="card-body">

                  <form method="POST" action="{{ route('file.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                      <label class="form-label fw-semibold">Mitra Radiologi</label>
                      <input type="file" class="form-control" name="file" id="hasilPemeriksaan" accept="application/pdf" @if(empty($hasilPemeriksaan?->file)) required @endif  >
                      <span id="fileLampiran" class="small text-muted d-block mt-1">
                        @if (!empty($hasilPemeriksaan?->file))
                          {{ $hasilPemeriksaan->fileLampiran }}
                        @else
                          Tidak ada file
                        @endif
                      </span>
                    </div>

                    <script>
                      document.addEventListener('DOMContentLoaded', function () {
                        const input = document.getElementById('hasilPemeriksaan');
                        const fileLampiran = document.getElementById('fileLampiran');

                        if (input && fileLampiran) {
                          input.addEventListener('change', () => {
                            if(input.files.length > 0) {
                              fileLampiran.textContent = input.files[0].name;
                            } else {
                              fileLampiran.textContent = 'Tidak ada file';
                            }
                          });
                        }
                      });
                    </script>

                    <div class="mb-3">
                      <label for="deskripsi" class="form-label fw-semibold">Deskripsi Hasil Analisa</label>
                      <textarea name="deskripsi" id="deskripsi" rows="6" class="form-control" placeholder="Deskripsi Hasil Analisa" ></textarea>
                    </div>

                    <div class="text-end mb-3">
                      <button type="submit" class="btn btn-primary fw-semibold px-4">
                        Unggah Draft
                      </button>
                    </div>

                    <div class="d-flex justify-content-center gap-3 gap-md-4 mt-2">
                      <a href="{{ route('dokter.homepage') }}"
                         class="btn btn-outline-primary fw-semibold px-4 px-md-5 rounded-pill">
                        Kembali
                      </a>
                      <button type="submit"
                              class="btn btn-primary fw-semibold px-4 px-md-5 rounded-pill">
                        Kirim
                      </button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          @endif

        </div> 

      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
