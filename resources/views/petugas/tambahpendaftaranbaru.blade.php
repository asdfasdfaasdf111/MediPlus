<!DOCTYPE html>
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
