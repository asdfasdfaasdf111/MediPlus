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
      @include('layout.sidebarpetugas')

        <div class="col-md-10 p-4 bg-light">
            <div class="card shadow-sm">
                <h4 class="text-center mb-4 pt-5" style="color:#173B7A;">Tambah Modalitas</h4>
                <div class="card-body px-5">

                  <form method="POST" action="{{ route('petugas.tambahModalitas') }}" novalidate>
                      @csrf

                      <div class="mb-3">
                        <label for="namaModalitas" class="form-label">Nama Modalitas</label>
                        <input type="text" class="form-control @error('namaModalitas') is-invalid @enderror" name="namaModalitas" id="namaModalitas" placeholder="CT Scan / MRI / USG" value="{{ old('namaModalitas') }}" autocomplete="off" autofocus >
                        @error('namaModalitas')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="mb-3">
                        <label for="jenisModalitas" class="form-label">Jenis Modalitas</label>
                        <input type="text" class="form-control @error('jenisModalitas') is-invalid @enderror" name="jenisModalitas" id="jenisModalitas"placeholder="CT, MR, US, X-Ray" value="{{ old('jenisModalitas') }}" autocomplete="off" >
                        @error('jenisModalitas')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="mb-3">
                        <label for="kodeRuang" class="form-label">Kode Ruang</label>
                        <input type="text" class="form-control @error('kodeRuang') is-invalid @enderror" name="kodeRuang" id="kodeRuang" placeholder="RAD-01" value="{{ old('kodeRuang') }}" autocomplete="off">
                        @error('kodeRuang')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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