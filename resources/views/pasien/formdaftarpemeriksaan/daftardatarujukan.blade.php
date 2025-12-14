{{-- <!DOCTYPE html>
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
</head> --}}

@extends('layout.app')

@section('title', 'Step 3 Daftar Data Rujukan')

@section('content')

@php
    use Carbon\Carbon;
    $draftData    = $masterPasien->draftPemeriksaan;
    $draftRujukan = $draftData->dataRujukan;
@endphp

<div class="bg-light text-dark">

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
        <form  id="formDataRujukan" method="POST" action="{{ $draftRujukan ? route('pasien.updateDataRujukan', ['dataPemeriksaan' => $draftData, 'dataRujukan' => $draftRujukan]) : route('pasien.bikinDataRujukan', $draftData) }}" enctype="multipart/form-data" class="bg-white border rounded-4 shadow-sm flex-grow-0" novalidate>
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
                <input type="text" class="form-control @error('namaFaskes') is-invalid @enderror" name="namaFaskes" id="namaFaskes" placeholder="Nama Fasilitas Kesehatan Perujuk" value="{{ old('namaFaskes', $draftRujukan->namaFaskes ?? '') }}"   >
                  @error('namaFaskes')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <div class="col-12 col-md-6">
                <label for="namaDokterPerujuk" class="form-label fw-semibold">Nama Dokter Perujuk</label>
                <input type="text" class="form-control @error('namaDokterPerujuk') is-invalid @enderror" name="namaDokterPerujuk" id="namaDokterPerujuk" placeholder="Nama Dokter Perujuk" value="{{ old('namaDokterPerujuk', $draftRujukan->namaDokterPerujuk ?? '') }}" >
                @error('namaDokterPerujuk')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12 col-md-6">
                <label for="tanggalPemeriksaanFaskes" class="form-label fw-semibold">Tanggal Pemeriksaan di Faskes</label>
                <input type="date" class="form-control @error('tanggalPemeriksaanFaskes') is-invalid @enderror" id="tanggalPemeriksaanFaskes" name="tanggalPemeriksaanFaskes" max="{{ date('Y-m-d') }}"  value="{{ old('tanggalPemeriksaanFaskes', $draftRujukan->tanggalPemeriksaanFaskes ?? '') }}" >
                @error('tanggalPemeriksaanFaskes')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="col-12">
                <label for="diagnosaKerja" class="form-label fw-semibold">Diagnosa Kerja</label>
                <input type="text" class="form-control @error('diagnosaKerja') is-invalid @enderror" name="diagnosaKerja" id="diagnosaKerja" placeholder="Hasil Diagnosa" value="{{ old('diagnosaKerja', $draftRujukan->diagnosaKerja ?? '') }}"   >
                  @error('diagnosaKerja')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <div class="col-12">
                <label for="alasanRujukan" class="form-label fw-semibold">Alasan Rujukan</label>
                <input type="text" class="form-control @error('alasanRujukan') is-invalid @enderror" name="alasanRujukan" id="alasanRujukan" placeholder="Alasan Rujukan"  value="{{ old('alasanRujukan', $draftRujukan->alasanRujukan ?? '') }}"   >
                  @error('alasanRujukan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <div class="col-12">
                <label for="permintaanPemeriksaan" class="form-label fw-semibold">Permintaan Pemeriksaan</label>
                <input type="text" class="form-control @error('permintaanPemeriksaan') is-invalid @enderror" name="permintaanPemeriksaan" id="permintaanPemeriksaan" placeholder="Permintaan Jenis Radiologi" value="{{ old('permintaanPemeriksaan', $draftRujukan->permintaanPemeriksaan ?? '') }}"   >
                  @error('permintaanPemeriksaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
              </div>

              <div class="col-12">
                <label for="formulirRujukan" class="form-label fw-semibold">Formulir Rujukan (PDF)</label>
                <input type="file" class="form-control  @error('formulirRujukan') is-invalid @enderror" name="formulirRujukan" id="formulirRujukan" accept="application/pdf" @if (!$draftRujukan) required @endif >
                @error('formulirRujukan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <div class="invalid-feedback" id="formulirRujukanErrorJs"></div>

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
{{-- </div>
</html> --}}

@endsection

@push('page-scripts')
    @vite(['resources/js/calendar.js'])
    @vite(['resources/js/jadwal-dinamis.js'])
    @vite(['resources/js/filerujukan.js'])
@endpush
