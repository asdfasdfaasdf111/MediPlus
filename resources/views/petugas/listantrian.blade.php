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
  @include('layout.navbar2')

  <div class="container-fluid ">
    <div class="row">
      @include('layout.sidebarpetugas')

      <div class="col-md-10 p-4  bg-light">
        @livewire('antrian-controller', ['rumahSakit' => $rumahSakit])
        <div class="text-center text-muted small py-3">
          © {{ date('Y') }} MediPlus — Petugas Panel
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
