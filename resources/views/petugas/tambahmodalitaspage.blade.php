{{-- resources/views/petugas/jenis_pemeriksaan/tambah.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Jenis Pemeriksaan</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark" style="height: 100vh;">

  @include('layout.navbar2') 

  <div class="container-fluid">
    <div class="row">

      {{-- SIDEBAR --}}
    <div class="col-md-2 min-vh-100 p-3 border-end">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}"
                class="nav-link {{ request()->routeIs('petugas.dashboard') ? 'text-primary fw-bold' : 'text-dark' }}"
                aria-current="{{ request()->routeIs('petugas.dashboard') ? 'page' : '' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
            </li>

            <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolajenispemeriksaan') }}"
                class="nav-link {{ request()->routeIs('petugas.kelolajenispemeriksaan','petugas.tambahjenispemeriksaanpage') ? 'text-primary fw-bold' : 'text-dark' }}"
                aria-current="{{ request()->routeIs('petugas.kelolajenispemeriksaan','petugas.tambahjenispemeriksaanpage') ? 'page' : '' }}">
                <i class="bi bi-clipboard2-check me-2"></i> Jenis Pemeriksaan
            </a>
            </li>

            <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolamodalitas') }}"
                class="nav-link {{ request()->routeIs('petugas.kelolamodalitas') ? 'text-primary fw-bold' : 'text-dark' }}"
                aria-current="{{ request()->routeIs('petugas.kelolamodalitas') ? 'page' : '' }}">
                <i class="bi bi-hdd-rack me-2"></i> Modalitas
            </a>
            </li>
        </ul>
    </div>

    <div class="col-md-10 p-4 bg-light">
    <div class="card shadow-sm">
        <h4 class="text-center mb-4 pt-5">Tambah Modalitas</h4>

        <div class="card-body px-5">
        @if ($errors->any())
            <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('petugas.tambahModalitas') }}">
            @csrf

            <div class="mb-3">
            <label for="namaModalitas" class="form-label">Nama Modalitas</label>
            <input type="text"
                    class="form-control @error('namaModalitas') is-invalid @enderror"
                    name="namaModalitas" id="namaModalitas"
                    placeholder="Contoh: CT Scan / MRI / USG"
                    value="{{ old('namaModalitas') }}" required autofocus autocomplete="off">
            @error('namaModalitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
            <label for="jenisModalitas" class="form-label">Jenis Modalitas</label>
            <input type="text"
                    class="form-control @error('jenisModalitas') is-invalid @enderror"
                    name="jenisModalitas" id="jenisModalitas"
                    placeholder="Contoh: CT, MR, US, X-Ray"
                    value="{{ old('jenisModalitas') }}" required autocomplete="off">
            @error('jenisModalitas') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
            <label for="kodeRuang" class="form-label">Kode Ruang</label>
            <input type="text"
                    class="form-control @error('kodeRuang') is-invalid @enderror"
                    name="kodeRuang" id="kodeRuang"
                    placeholder="Contoh: RAD-01"
                    value="{{ old('kodeRuang') }}" required autocomplete="off">
            @error('kodeRuang') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-center gap-3 pt-3">
            <a href="{{ route('petugas.kelolamodalitas') }}"
                class="btn btn-outline-primary px-5 rounded-pill">
                Kembali
            </a>
            <button type="submit" class="btn btn-primary px-5 rounded-pill">
                Simpan
            </button>
            </div>
        </form>
        </div>
    </div>
    </div>

    </div>
    </div>


  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>