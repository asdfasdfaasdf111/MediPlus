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
  $rumahSakit = $petugas->rumahSakit;
@endphp

<body class="bg-white text-dark">
  @foreach ($rumahSakit->jenisPemeriksaan as $jenisPemeriksaan)
      @if ($jenisPemeriksaan->counterHariIni === null)
          @continue
      @endif
  @endforeach
</body>
</html>
