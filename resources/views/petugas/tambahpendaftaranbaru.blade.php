{{-- <!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Petugas | Detail Pemeriksaan</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

@php
  use Carbon\Carbon;
  // $rumahSakit       = $dataPemeriksaan->rumahSakit;
  // $jenisPemeriksaan = $dataPemeriksaan->jenisPemeriksaan;
  // $dokter           = $dataPemeriksaan->dokter;
  // $dataPasien       = $dataPemeriksaan->dataPasien;
  // $dataRujukan      = $dataPemeriksaan->dataRujukan;

  // $jamAkhir = Carbon::parse($dataPemeriksaan->rentangWaktuKedatangan)->addHour()->toTimeString();

@endphp

<body class="bg-white text-dark">
  <form action="{{ route('petugas.submitemailpasien') }}" method="POST">
    @csrf
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>
    @error('email')
        <div class="text-red-500">{{ $message }}</div>
    @enderror
    <button type="submit">Submit</button>
    <a href="{{ route('register') }}">Buat Akun Baru</a>
  </form>
</body>
</html>

 --}}


@extends('layout.staff')

@section('title', 'Daftar Onsite Pasien')

@section('content')
<div class="container-fluid">
  <div class="row">

    {{-- Sidebar --}}
    @include('layout.sidebarpetugas')

    {{-- Konten --}}
    <div class="col-md-10 p-4 bg-light">
      <div class="card shadow-sm">

        <h4 class="text-center mb-4 pt-5" style="color:#173B7A;">
          Daftar Onsite Pasien
        </h4>

        <div class="card-body px-5">

          <form action="{{ route('petugas.submitemailpasien') }}" method="POST" novalidate>
            @csrf

            <div class="mb-4">
              <label for="email" class="form-label">Email Pasien</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Pasien" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-center gap-3 mt-5 pt-5">
              <a href="{{ route('register') }}" class="btn btn-outline-primary px-5 rounded-pill">
                Buat Akun Baru
              </a>
              <button type="submit" class="btn btn-primary px-5 rounded-pill">
                Berikutnya
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>

  </div>
</div>
@endsection
 