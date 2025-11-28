<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemeriksaan Pasien Baru</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
</head>

@php
    use Carbon\Carbon;
    $draftData = $masterPasien->draftPemeriksaan;
    $draftRujukan = $draftData->dataRujukan;
@endphp

<form method="POST" action="{{ $draftRujukan ? route('pasien.updateDataRujukan', ['dataPemeriksaan' => $draftData, 'dataRujukan' => $draftRujukan]) : route('pasien.bikinDataRujukan', $draftData) }}" enctype="multipart/form-data">
    @csrf
    @if ($draftRujukan)
        @method('PUT')
    @endif
    <div>Data Rujukan</div>
    <div>Nama Fasilitas Kesehatan Perujuk</div>
    <input type="text"  class="form-control"
                        name="namaFaskes" id="namaFaskes"
                        placeholder="Nama Fasilitas Kesehatan Perujuk"
                        @if(!empty($draftRujukan?->namaFaskes))
                            value="{{ $draftRujukan->namaFaskes }}"
                        @endif
                        required>

    <div>Nama Dokter Perujuk</div>
    <input type="text"  class="form-control"
                        name="namaDokterPerujuk" id="namaDokterPerujuk"
                        placeholder="Nama Dokter Perujuk"
                        @if(!empty($draftRujukan?->namaDokterPerujuk))
                            value="{{ $draftRujukan->namaDokterPerujuk }}"
                        @endif
                        required>

    <div>Tanggal Pemeriksaan di Faskes</div>
    <input type="date" id="tanggalPemeriksaanFaskes" name="tanggalPemeriksaanFaskes" max="{{ date('Y-m-d') }}"
                        @if(!empty($draftRujukan?->tanggalPemeriksaanFaskes))
                            value="{{ $draftRujukan->tanggalPemeriksaanFaskes }}"
                        @endif
                        required>
                        

    <div>Diagnosa Kerja</div>
    <input type="text"  class="form-control"
                        name="diagnosaKerja" id="diagnosaKerja"
                        placeholder="Hasil Diagnosa"
                        @if(!empty($draftRujukan?->diagnosaKerja))
                            value="{{ $draftRujukan->diagnosaKerja }}"
                        @endif
                        required>

    <div>Alasan Rujukan</div>
    <input type="text"  class="form-control"
                        name="alasanRujukan" id="alasanRujukan"
                        placeholder="Alasan Rujukan"
                        @if(!empty($draftRujukan?->alasanRujukan))
                            value="{{ $draftRujukan->alasanRujukan }}"
                        @endif
                        required>
    
    <div>Permintaan Pemeriksaan</div>
    <input type="text"  class="form-control"
                        name="permintaanPemeriksaan" id="permintaanPemeriksaan"
                        placeholder="Permintaan Jenis Radiologi"
                        @if(!empty($draftRujukan?->permintaanPemeriksaan))
                            value="{{ $draftRujukan->permintaanPemeriksaan }}"
                        @endif
                        required>

    <div>Formulir Rujukan</div>
    <input type="file" class="form-control" name="formulirRujukan" id="formulirRujukan" accept="application/pdf" 
    @if(empty($draftRujukan?->formulirRujukan)) required @endif>
    <span id="fileName">
        @if (!empty($draftRujukan?->formulirRujukan))
            {{ $draftRujukan->namaFile }}
        @else
            No File Chosen
        @endif
    </span>

    <script>
        const input = document.getElementById('formulirRujukan');
        const fileName = document.getElementById('fileName');
      
        input.addEventListener('change', () => {
          if (input.files.length > 0) {
            fileName.textContent = input.files[0].name;
          } else {
            fileName.textContent = 'No file chosen';
          }
        });
    </script>

    <div class="d-flex justify-content-center gap-3 pt-3">
        <a href="{{ route('pasien.daftartipepasien') }}" 
           class="btn btn-outline-primary px-5 rounded-pill">
           Kembali
        </a>
        <button id="submitBtn" type="submit" class="btn btn-primary px-5 rounded-pill">
            Berikutnya
        </button>
    </div>
</form>
