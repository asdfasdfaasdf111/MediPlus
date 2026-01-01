<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokter | Detail Pemeriksaan</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

@php
    use Carbon\Carbon;
    $rumahSakit = $dataPemeriksaan->rumahSakit;
    $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
    $dokter = $dataPemeriksaan->dokter;
    $dataPasien = $dataPemeriksaan->dataPasien;
    $dataRujukan = $dataPemeriksaan->dataRujukan;
    $hasilPemeriksaan = $dataPemeriksaan->hasilPemeriksaan;
    $draftLaporan = $dokter->draftLaporan;
    $jump = $jenisPemeriksaan->getJump();
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
                      {{ $jenisPemeriksaan->namaJenisPemeriksaan }}
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
                      {{ Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour($jump)->toTimeString() }}
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

          {{-- DATA RUJUKAN --}}
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
                        <a href="{{ asset('storage/' . $dataRujukan->formulirRujukan) }}" target="_blank" class="text-decoration-none">
                          <i class="bi bi-file-earmark-pdf me-1"></i>{{ $dataRujukan->namaFile }}
                        </a>
                      </div>
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>

          {{-- UPLOAD HASIL PUNYA LEO --}}
                    @if($dataPemeriksaan->statusDokter == 'Menunggu Laporan')
            <div class="col-12">
              <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-header fw-semibold d-flex align-items-center">
                  <i class="bi bi-file-earmark-arrow-up me-2"></i>
                  Unggah Hasil Pemeriksaan
                </div>

                <div class="card-body">
                  <form method="POST"
                        action="{{ route('dokter.uploadLaporan', $dataPemeriksaan) }}"
                        enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                      <label class="form-label fw-semibold">Mitra Radiologi</label>
                      <input type="file"
                            class="form-control @error('files') is-invalid @enderror"
                            name="files[]" id="hasilPemeriksaan" multiple required>

                      @error('files')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                      @enderror

                      <div id="file-list" class="mt-2 small text-primary fw-bold"></div>

                      <div class="form-text mt-1 text-muted">
                          <i class="bi bi-info-circle me-1"></i> Anda bisa memilih lebih dari 1 file (dalam 1 kali unggah).
                      </div>
                    </div>

                    <div class="mb-3">
                      <label for="deskripsi" class="form-label fw-semibold">Deskripsi Hasil Analisa</label>
                      <textarea name="deskripsi"
                                  id="deskripsi"
                                  rows="6"
                                  class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Deskripsi Hasil Analisa">{{ old('deskripsi') }}</textarea>

                        @error('deskripsi')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                        @enderror
                      </div>
                  
                  <div class="d-flex flex-wrap gap-2 position-relative">
                    <button type="button"
                            class="btn btn-outline-secondary fw-semibold px-4"
                            data-bs-toggle="modal"
                            data-bs-target="#popupDraft">
                      Unggah Draft
                    </button>

                    <div class="position-absolute start-50 translate-middle-x">
                      <button type="submit"
                              class="btn btn-primary fw-semibold px-4 px-md-5 rounded-pill">
                        Kirim
                      </button>
                    </div>
                  </div>


            {{-- Modal draft --}}
            <div class="modal fade" id="popupDraft" tabindex="-1" aria-labelledby="popupDraftLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border-radius:16px;">
                  <div class="modal-header">
                    <h5 id="popupDraftLabel" class="modal-title fw-bold">Pilih Draft</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">
                    @if(isset($draftLaporan) && $draftLaporan->count())
                      <div class="list-group">
                        @foreach($draftLaporan as $draft)
                          <button
                            type="button"
                            class="list-group-item list-group-item-action template-item"
                            data-description="{{ htmlspecialchars($draft->deskripsi) }}"
                          >
                            {{ $draft->judul }}
                          </button>
                        @endforeach
                      </div>
                    @else
                      <p class="text-muted mb-0">Tidak ada draft laporan tersedia.</p>
                    @endif
                  </div>


                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                  </div>
                </div>
              </div>
            </div>
            

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const textarea = document.getElementById('deskripsi');
        
                    document.querySelectorAll('.template-item').forEach(function(btn) {
                        btn.addEventListener('click', function () {
                            const desc = this.getAttribute('data-description') || '';
                            textarea.value = desc;
                            const modalEl = document.getElementById('popupDraft');
                            const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                            modal.hide();
                        });
                    });
                });
            </script>

            @elseif($dataPemeriksaan->statusDokter === 'Laporan Terkirim' || $dataPemeriksaan->statusDokter === 'Selesai')
              <div class="col-12">
                <div class="card shadow-sm border-0 rounded-4">
                  <div class="card-header fw-semibold d-flex align-items-center">
                    <i class="bi bi-clipboard-check me-2"></i>
                    Hasil Pemeriksaan
                  </div>
                  <div class="card-body">
                    <div class="mb-2">
                      <div class="small text-muted">Hasil Analisa</div>
                      <div class="fw-semibold text-break">
                        {{ $hasilPemeriksaan->hasilPemeriksaan }}
                      </div>
                    </div>

                    <div class="mt-3">
                      <div class="small text-muted">Unduh Lampiran</div>
                      <div class="mt-1">
                        @foreach(json_decode($hasilPemeriksaan->fileLampiran) as $filePath)
                          <a class="btn btn-outline-primary btn-sm me-2 mb-2"
                            href="{{ Storage::url($filePath) }}"
                            target="_blank">
                            <i class="bi bi-download me-1"></i>Download
                          </a>
                        @endforeach
                      </div>
                    </div>
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
