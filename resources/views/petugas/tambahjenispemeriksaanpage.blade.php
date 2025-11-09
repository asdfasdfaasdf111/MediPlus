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

  @include('layout.navbar2') {{-- samakan dengan halaman admin --}}

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


      {{-- Konten --}}
      <div class="col-md-10 p-4 bg-light">
        <div class="card shadow-sm">
          <h4 class="text-center mb-4 pt-5">Tambah Jenis Pemeriksaan</h4>
          <div class="card-body px-5">

            {{-- Notifikasi validasi (opsional) --}}
            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form method="POST" action="{{ route('petugas.tambahJenisPemeriksaan') }}">
              @csrf

              {{-- Modalitas --}}
              <div class="mb-3">
                <label for="modalitasId" class="form-label">Modalitas</label>
                <select name="modalitasId" id="modalitasId"
                        class="form-select @error('modalitasId') is-invalid @enderror" required>
                  @php
                    $listModalitas = $petugas->rumahSakit->modalitas ?? collect();
                  @endphp
                  @if($listModalitas->isEmpty())
                    <option value="" disabled selected>Belum ada modalitas di RS Anda</option>
                  @else
                    <option value="" disabled selected>Pilih Modalitas</option>
                    @foreach($listModalitas as $modalitas)
                      <option value="{{ $modalitas->id }}"
                        {{ old('modalitasId') == $modalitas->id ? 'selected' : '' }}>
                        {{ $modalitas->namaModalitas }}
                      </option>
                    @endforeach
                  @endif
                </select>
                @error('modalitasId') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Nama Jenis Pemeriksaan --}}
              <div class="mb-3">
                <label for="namaJenisPemeriksaan" class="form-label">Nama Jenis Pemeriksaan</label>
                <input type="text" class="form-control @error('namaJenisPemeriksaan') is-invalid @enderror"
                       name="namaJenisPemeriksaan" id="namaJenisPemeriksaan"
                       placeholder="Contoh: CT-Scan Abdomen"
                       value="{{ old('namaJenisPemeriksaan') }}" required>
                @error('namaJenisPemeriksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Nama Pemeriksaan Spesifik --}}
              <div class="mb-3">
                <label for="namaPemeriksaanSpesifik" class="form-label">Nama Pemeriksaan Spesifik</label>
                <input type="text" class="form-control @error('namaPemeriksaanSpesifik') is-invalid @enderror"
                       name="namaPemeriksaanSpesifik" id="namaPemeriksaanSpesifik"
                       placeholder="Contoh: CT-Scan Abdomen Kontras"
                       value="{{ old('namaPemeriksaanSpesifik') }}" required>
                @error('namaPemeriksaanSpesifik') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Kelompok Jenis Pemeriksaan --}}
              <div class="mb-3">
                <label for="kelompokJenisPemeriksaan" class="form-label">Kelompok Jenis Pemeriksaan</label>
                <input type="text" class="form-control @error('kelompokJenisPemeriksaan') is-invalid @enderror"
                       name="kelompokJenisPemeriksaan" id="kelompokJenisPemeriksaan"
                       placeholder="Contoh: Abdomen / Thorax / Kepala"
                       value="{{ old('kelompokJenisPemeriksaan') }}" required>
                @error('kelompokJenisPemeriksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Memakai Kontras (switch) --}}
              <div class="mb-3">
                <label class="form-label d-block">Memakai Kontras</label>
                <input type="hidden" name="pemakaianKontras" value="0">
                <div class="form-check form-switch">
                  <input class="form-check-input @error('pemakaianKontras') is-invalid @enderror" type="checkbox"
                         role="switch" id="pemakaianKontras" name="pemakaianKontras" value="1"
                         {{ old('pemakaianKontras') == 1 ? 'checked' : '' }}>
                  <label class="form-check-label" for="pemakaianKontras">Aktifkan jika pemeriksaan membutuhkan kontras</label>
                  @error('pemakaianKontras') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>

              {{-- Lama Pemeriksaan (menit) --}}
              <div class="mb-3">
                <label for="lamaPemeriksaan" class="form-label">Lama Pemeriksaan</label>
                <div class="input-group" style="max-width: 260px;">
                  <input type="number" min="1" step="1"
                         class="form-control text-center @error('lamaPemeriksaan') is-invalid @enderror"
                         name="lamaPemeriksaan" id="lamaPemeriksaan"
                         placeholder="Durasi" value="{{ old('lamaPemeriksaan') }}" required>
                  <span class="input-group-text">menit</span>
                  @error('lamaPemeriksaan') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>

              {{-- Didampingi Dokter (switch) --}}
              <div class="mb-4">
                <label class="form-label d-block">Perlu Didampingi Dokter</label>
                <input type="hidden" name="diDampingiDokter" value="0">
                <div class="form-check form-switch">
                  <input class="form-check-input @error('diDampingiDokter') is-invalid @enderror" type="checkbox"
                         role="switch" id="diDampingiDokter" name="diDampingiDokter" value="1"
                         {{ old('diDampingiDokter') == 1 ? 'checked' : '' }}>
                  <label class="form-check-label" for="diDampingiDokter">Aktifkan jika perlu pendampingan dokter</label>
                  @error('diDampingiDokter') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
              </div>

              {{-- Tombol Aksi (sama seperti admin) --}}
              <div class="d-flex justify-content-center gap-3 pt-3">
                <a href="{{ route('petugas.kelolajenispemeriksaan') }}"
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
