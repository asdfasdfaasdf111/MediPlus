<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pilih Jadwal Pemeriksaan - Mediplus</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark">

  {{-- Navbar khusus pasien --}}
  @include('layout.navbar2')

  <div class="container-fluid">
    <div class="row">

{{-- Sidebar --}}
<div class="col-md-2 min-vh-100 p-2 mt-3">
  <ul class="nav flex-column">
    <li class="nav-item mb-2">
      <a href="{{ route('pasien.pendaftaran') }}" 
         class="nav-link {{ request()->routeIs('pasien.pendaftaran') ? 'text-primary fw-bold' : 'text-dark' }}">
        <i class="bi bi-calendar-week me-2"></i> Pilih Jadwal
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="{{ route('pasien.pendaftaran.tipepasien') }}" 
         class="nav-link {{ request()->routeIs('pasien.pendaftaran.tipepasien') ? 'text-primary fw-bold' : 'text-dark' }}">
        <i class="bi bi-person-badge me-2"></i> Tipe Pasien
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="{{ route('pasien.pendaftaran.formdatadiri') }}" 
         class="nav-link {{ request()->routeIs('pasien.pendaftaran.formdatadiri') ? 'text-primary fw-bold' : 'text-dark' }}">
        <i class="bi bi-card-text me-2"></i> Form Data Diri
      </a>
    </li>
    <li class="nav-item mb-2">
      <a href="{{ route('pasien.pendaftaran.datarujukan') }}" 
         class="nav-link {{ request()->routeIs('pasien.pendaftaran.datarujukan') ? 'text-primary fw-bold' : 'text-dark' }}">
        <i class="bi bi-file-earmark-arrow-up me-2"></i> Data Rujukan
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('pasien.pendaftaran.ringkasan') }}" 
         class="nav-link {{ request()->routeIs('pasien.pendaftaran.ringkasan') ? 'text-primary fw-bold' : 'text-dark' }}">
        <i class="bi bi-clipboard-check me-2"></i> Ringkasan
      </a>
    </li>
  </ul>
</div>


      {{-- Content --}}
      <div class="col-md-10 p-4 bg-light">
        <h3 class="fw-bold text-center mb-4">Pilih Jadwal Pemeriksaan</h3>

        <form action="{{ route('pasien.pendaftaran.tipepasien') }}" method="GET">
          <div class="row g-4">
            {{-- Kolom kiri --}}
            <div class="col-lg-7">
              <div class="mb-3">
                <label class="form-label">Rumah Sakit</label>
                <select name="rumah_sakit" class="form-select" required>
                  <option value="" selected disabled>Pilih Rumah Sakit</option>
                  @foreach(($rumahsakits ?? collect()) as $rs)
                    <option value="{{ $rs->id }}">RS {{ $rs->nama }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Jenis Pemeriksaan</label>
                <select name="jenis" class="form-select" required>
                  <option value="" selected disabled>Pilih Jenis Pemeriksaan</option>
                  @foreach(($jenisPemeriksaans ?? collect()) as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Pemeriksaan Spesifik</label>
                <select name="spesifik" class="form-select">
                  <option value="" selected disabled>Pilih Pemeriksaan Spesifik</option>
                  @foreach(($pemeriksaanSpesifik ?? collect()) as $sp)
                    <option value="{{ $sp->id }}">{{ $sp->nama }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- Kolom kanan --}}
            <div class="col-lg-5">
              <label class="form-label">Tanggal Pemeriksaan</label>
              <input type="date" name="tanggal" class="form-control" 
                     value="{{ now()->toDateString() }}" required>
            </div>
          </div>

          <div class="mt-4">
            <label class="form-label d-block">Rentang Waktu Kedatangan</label>

            @php
              $slots = [
                '08:00-09:00','09:00-10:00','10:00-11:00','11:00-12:00',
                '12:00-13:00','13:00-14:00','14:00-15:00','15:00-16:00'
              ];
            @endphp

            <div class="d-flex flex-wrap gap-2">
              @foreach($slots as $i => $slot)
                <input type="radio" class="btn-check" name="slot" id="slot{{ $i }}" 
                       value="{{ $slot }}" autocomplete="off" {{ $i===0 ? 'checked' : '' }}>
                <label class="btn btn-outline-secondary" for="slot{{ $i }}">
                  {{ str_replace('-', ' - ', $slot) }}
                </label>
              @endforeach
            </div>
          </div>

          <div class="d-flex justify-content-center gap-3 mt-5">
            <a href="{{ route('pasien.homepage') }}" class="btn btn-outline-primary px-4">Kembali</a>
            <button type="submit" class="btn btn-primary px-4">Berikutnya</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
