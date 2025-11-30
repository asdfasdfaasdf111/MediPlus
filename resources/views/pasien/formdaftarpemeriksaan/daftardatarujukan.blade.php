<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemeriksaan Pasien Baru</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
    use Carbon\Carbon;
    $draftData    = $masterPasien->draftPemeriksaan;
    $draftRujukan = $draftData->dataRujukan;
@endphp

<body class="bg-light text-dark">

  <div class="container-fluid py-3 py-md-4">
    <div class="row justify-content-center">
      <div class="col-12 col-lg-10 col-xl-8 min-vh-100 d-flex flex-column">

        <div class="d-flex align-items-start justify-content-between gap-3 mb-3">
          <div>
            <h4 class="mb-1" style="color:#173B7A;">Data Rujukan</h4>
            <div class="text-muted small">
              Isi informasi fasilitas kesehatan perujuk, dokter, dan formulir rujukan.
            </div>
          </div>
        </div>

        {{-- FORM --}}
        <form method="POST"
              action="{{ $draftRujukan ? route('pasien.updateDataRujukan', ['dataPemeriksaan' => $draftData, 'dataRujukan' => $draftRujukan]) : route('pasien.bikinDataRujukan', $draftData) }}" enctype="multipart/form-data" class="bg-white border rounded-4 shadow-sm flex-grow-0">
            @csrf
            @if ($draftRujukan)
                @method('PUT')
            @endif

            <div class="border-bottom px-4 py-3">
              <div class="d-flex align-items-center gap-2">
                <i class="bi bi-file-medical fs-5 text-primary"></i>
                <div>
                  <div class="fw-semibold">Data Rujukan</div>
                </div>
              </div>
            </div>

            <div class="row g-3 px-4 py-3">

              <div class="col-12">
                <label for="namaFaskes" class="form-label fw-semibold">Nama Fasilitas Kesehatan Perujuk</label>
                <input type="text" class="form-control" name="namaFaskes" id="namaFaskes" placeholder="Nama Fasilitas Kesehatan Perujuk"
                       @if(!empty($draftRujukan?->namaFaskes))
                           value="{{ $draftRujukan->namaFaskes }}"
                       @endif
                    required>
              </div>

              <div class="col-12 col-md-6">
                <label for="namaDokterPerujuk" class="form-label fw-semibold">Nama Dokter Perujuk</label>
                <input type="text" class="form-control" name="namaDokterPerujuk" id="namaDokterPerujuk" placeholder="Nama Dokter Perujuk"
                       @if(!empty($draftRujukan?->namaDokterPerujuk))
                           value="{{ $draftRujukan->namaDokterPerujuk }}"
                       @endif
                    required>
              </div>

              <div class="col-12 col-md-6">
                <label for="tanggalPemeriksaanFaskes" class="form-label fw-semibold">Tanggal Pemeriksaan di Faskes</label>
                <input type="date" class="form-control" id="tanggalPemeriksaanFaskes" name="tanggalPemeriksaanFaskes" max="{{ date('Y-m-d') }}"
                       @if(!empty($draftRujukan?->tanggalPemeriksaanFaskes))
                           value="{{ $draftRujukan->tanggalPemeriksaanFaskes }}"
                       @endif
                    required>
              </div>

              <div class="col-12">
                <label for="diagnosaKerja" class="form-label fw-semibold">Diagnosa Kerja</label>
                <input type="text" class="form-control" name="diagnosaKerja" id="diagnosaKerja" placeholder="Hasil Diagnosa"
                       @if(!empty($draftRujukan?->diagnosaKerja))
                           value="{{ $draftRujukan->diagnosaKerja }}"
                       @endif
                    required>
              </div>

              <div class="col-12">
                <label for="alasanRujukan" class="form-label fw-semibold">Alasan Rujukan</label>
                <input type="text" class="form-control" name="alasanRujukan" id="alasanRujukan" placeholder="Alasan Rujukan"
                       @if(!empty($draftRujukan?->alasanRujukan))
                           value="{{ $draftRujukan->alasanRujukan }}"
                       @endif
                    required>
              </div>

              <div class="col-12">
                <label for="permintaanPemeriksaan" class="form-label fw-semibold">Permintaan Pemeriksaan</label>
                <input type="text" class="form-control" name="permintaanPemeriksaan" id="permintaanPemeriksaan" placeholder="Permintaan Jenis Radiologi"
                       @if(!empty($draftRujukan?->permintaanPemeriksaan))
                           value="{{ $draftRujukan->permintaanPemeriksaan }}"
                       @endif
                    required>
              </div>

              <div class="col-12">
                <label for="formulirRujukan" class="form-label fw-semibold">Formulir Rujukan (PDF)</label>
                <input type="file" class="form-control" name="formulirRujukan" id="formulirRujukan" accept="application/pdf"
                       @if(empty($draftRujukan?->formulirRujukan)) required @endif>

                <div class="small text-muted mt-1" id="fileName">
                    @if (!empty($draftRujukan?->formulirRujukan))
                        {{ $draftRujukan->namaFile }}
                    @else
                        No File Chosen
                    @endif
                </div>
              </div>

            </div>

            <div class="border-top text-center px-4 py-3">
              <div class="d-inline-flex gap-2">
                <a href="{{ route('pasien.daftartipepasien') }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
                   Kembali
                </a>
                <button id="submitBtn" type="submit" class="btn btn-primary px-4 px-md-5 rounded-pill">
                    Berikutnya
                </button>
              </div>
            </div>
        </form>

      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>

  <script>
    // File name display untuk formulir rujukan
    document.addEventListener('DOMContentLoaded', function () {
      const input = document.getElementById('formulirRujukan');
      const fileName = document.getElementById('fileName');

      if (!input || !fileName) return;

      input.addEventListener('change', () => {
        if (input.files.length > 0) {
          fileName.textContent = input.files[0].name;
        } else {
          fileName.textContent = 'No File Chosen';
        }
      });
    });
  </script>
</body>
</html>
