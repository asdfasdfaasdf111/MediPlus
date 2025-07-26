<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Pasien</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
</head>
<body class="bg-white text-dark">

    @include('layout.navbar')

   <!-- Hero Section -->
<div class="container-fluid p-0">
  <div class="position-relative">
    <img src="{{ asset('images/HeroSection.jpg') }}" alt="Hero Background" class="img-fluid w-100" style="height: 70vh; object-fit: cover;">

    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center">
      <div class="container px-5">
        <div class="col-md-6">
          <h2 class="display-4 fw-bold" style="color: #000000;">Mudah, Cepat, dan Tanpa Antri babayo.</h2>
          <p class="lead" style="color: #000000;">
            Pilih jadwal pemeriksaan, daftar online, dan langsung datang sesuai waktu yang Anda tentukan.
          </p>
          <a href="{{ route('pasien.pendaftaran') }}" class="btn btn-lg mt-2 text-white fw-semibold" style="background-color: #ff9900;">
            Daftar Pemeriksaan
          </a>
        </div>
      </div>
    </div>
  </div>
</div>


    <!-- Section: Rumah Sakit Mitra -->
    <div class="container text-center py-5">
        <h2 class="fw-bold text-primary">Rumah Sakit Mitra</h2>
        {{-- Konten rumah sakit mitra bisa ditambahkan di sini --}}
    </div>

    <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
