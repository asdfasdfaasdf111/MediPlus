{{-- resources/views/petugas/jenis_pemeriksaan/tambah.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Kelompok Jenis Pemeriksaan</title>
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
                <h4 class="text-center mb-4 pt-5" style="color:#173B7A;">Tambah Kelompok Jenis Pemeriksaan</h4>
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

        <form method="POST" action="{{ route('petugas.tambahKelompokJenisPemeriksaan') }}">
            @csrf

            <div class="mb-3">
            <label for="namaKelompok" class="form-label">Nama Kelompok Jenis Pemeriksaan</label>
            <input type="text"
                    class="form-control @error('namaKelompok') is-invalid @enderror"
                    name="namaKelompok" id="namaKelompok"
                    placeholder="Contoh: CT Scan / MRI / USG"
                    value="{{ old('namaKelompok') }}" required autofocus autocomplete="off">
            @error('namaKelompok') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-center gap-3 pt-3">
            <a href="{{ route('petugas.kelolakelompokjenispemeriksaan') }}"
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