@extends('layout.staff')

@section('title', 'Petugas | Data Rujukan')

@vite(['resources/js/calendar.js'])
@vite(['resources/js/jadwal-dinamis-petugas.js'])

@section('content')

@php
    use Carbon\Carbon;
    $draftData    = $masterPasien->draftPemeriksaan;
    $draftRujukan = $draftData->dataRujukan;
@endphp

<div class="container-fluid">
  <div class="row">

    @include('layout.sidebarpetugas')

    <div class="col-md-10 p-4 bg-light min-vh-100">

      {{-- FORM --}}
      <form method="POST"
            action="{{ $draftRujukan ? route('petugas.updateDataRujukan', ['dataPemeriksaan' => $draftData, 'dataRujukan' => $draftRujukan]) : route('petugas.bikinDataRujukan', $draftData) }}" enctype="multipart/form-data" class="bg-white border rounded-4 shadow-sm">
        @csrf
        @if ($draftRujukan)
            @method('PUT')
        @endif

        <div class="border-bottom px-4 py-3">
          <div class="d-flex align-items-center gap-2">
            <i class="bi bi-file-medical fs-5 text-primary"></i>
            <div class="fw-semibold">Langkah 3 : Data Rujukan</div>
          </div>
        </div>

        <div class="row g-3 px-4 py-3">

              <div class="col-12">
                <label class="form-label fw-semibold">Nama Fasilitas Kesehatan Perujuk</label>
                <input type="text" name="namaFaskes"  class="form-control @error('namaFaskes') is-invalid @enderror" placeholder="Nama Fasilitas Kesehatan Perujuk" value="{{ old('namaFaskes', $draftRujukan->namaFaskes ?? '') }}">

                @error('namaFaskes')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Nama Dokter Perujuk</label>
                <input type="text" name="namaDokterPerujuk" class="form-control @error('namaDokterPerujuk') is-invalid @enderror" placeholder="Nama Dokter Perujuk" value="{{ old('namaDokterPerujuk', $draftRujukan->namaDokterPerujuk ?? '') }}">

                @error('namaDokterPerujuk')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              <div class="col-12 col-md-6">
                <label class="form-label fw-semibold">Tanggal Pemeriksaan di Faskes</label>
                <input type="date" name="tanggalPemeriksaanFaskes" max="{{ date('Y-m-d') }}" class="form-control @error('tanggalPemeriksaanFaskes') is-invalid @enderror" value="{{ old('tanggalPemeriksaanFaskes', $draftRujukan->tanggalPemeriksaanFaskes ?? '') }}">

                @error('tanggalPemeriksaanFaskes')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


             <div class="col-12">
                <label class="form-label fw-semibold">Diagnosa Kerja</label>
                <input type="text" name="diagnosaKerja" class="form-control @error('diagnosaKerja') is-invalid @enderror" placeholder="Hasil Diagnosa" value="{{ old('diagnosaKerja', $draftRujukan->diagnosaKerja ?? '') }}">

                @error('diagnosaKerja')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              <div class="col-12">
                <label class="form-label fw-semibold">Alasan Rujukan</label>
                <input type="text" name="alasanRujukan" class="form-control @error('alasanRujukan') is-invalid @enderror" placeholder="Alasan Rujukan" value="{{ old('alasanRujukan', $draftRujukan->alasanRujukan ?? '') }}">

                @error('alasanRujukan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              <div class="col-12">
                <label class="form-label fw-semibold">Permintaan Pemeriksaan</label>
                <input type="text" name="permintaanPemeriksaan"  class="form-control @error('permintaanPemeriksaan') is-invalid @enderror" placeholder="Permintaan Jenis Radiologi" value="{{ old('permintaanPemeriksaan', $draftRujukan->permintaanPemeriksaan ?? '') }}">

                @error('permintaanPemeriksaan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>


              <div class="col-12">
                <label class="form-label fw-semibold">Formulir Rujukan (PDF)</label>
                <input type="file" name="formulirRujukan" accept="application/pdf"  class="form-control @error('formulirRujukan') is-invalid @enderror" @if(!$draftRujukan) required @endif>

                @error('formulirRujukan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="small text-muted mt-1">
                  {{ $draftRujukan->namaFile ?? 'No File Chosen' }}
                </div>
              </div>
            </div>

            <div class="border-top text-center px-4 py-3">
              <div class="d-inline-flex gap-2">
                <a href="{{ route('petugas.daftartipepasien', $masterPasien) }}" class="btn btn-outline-primary px-4 px-md-5 rounded-pill">
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

<script>
    // File name display untuk formulir rujukan -> ngikutin pasien
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



@endsection
