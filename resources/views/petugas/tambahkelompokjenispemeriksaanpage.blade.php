@extends('layout.staff')

@section('title', 'Tambah Kelompok Jenis Pemeriksaan')

@section('content')

<div class="container-fluid">
  <div class="row">
    @include('layout.sidebarpetugas')

    <div class="col-md-10 p-4 bg-light">
      <div class="card shadow-sm">
        <h4 class="text-center mb-4 pt-5" style="color:#173B7A;">
          Tambah Kelompok Jenis Pemeriksaan
        </h4>

        <div class="card-body px-5">

          <form method="POST" action="{{ route('petugas.tambahKelompokJenisPemeriksaan') }}" novalidate>
            @csrf

            <div class="mb-3">
              <label for="namaKelompok" class="form-label">
                Nama Kelompok Jenis Pemeriksaan
              </label>

              <input type="text" class="form-control @error('namaKelompok') is-invalid @enderror" name="namaKelompok"  id="namaKelompok"  placeholder="Contoh: CT Scan / MRI / USG " value="{{ old('namaKelompok') }}" autocomplete="off" autofocus required>
              @error('namaKelompok')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
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

@endsection
