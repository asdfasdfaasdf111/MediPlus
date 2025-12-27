@extends('layout.staff')

@section('title', 'Daftar Onsite Pasien')

@section('content')
<div class="container-fluid">
  <div class="row">

    {{-- Sidebar --}}
    @include('layout.sidebarpetugas')

    {{-- Konten --}}
    <div class="col-md-10 p-4 bg-light">
      <div class="card shadow-sm">

        <h4 class="text-center mb-2 pt-5" style="color:#173B7A;">
          Daftar Onsite Pasien
        </h4>
        <p class="text-center text-muted mb-4">
          Digunakan oleh petugas untuk mendaftarkan pasien yang datang langsung ke rumah sakit.
        </p>


        <div class="card-body px-5">

          <div class="alert alert-info d-flex align-items-start gap-3 mb-4">
            <i class="bi bi-info-circle-fill mt-1"></i>
            <div>
              <div class="fw-semibold">Petunjuk Pengisian</div>
              <div class="small">
                Masukkan email pasien untuk melanjutkan proses pendaftaran.
                <ul class="mb-0 ps-3">
                  <li>Jika email sudah terdaftar, data pasien akan dimuat otomatis.</li>
                  <li>Jika belum terdaftar, silakan buat akun baru.</li>
                </ul>
              </div>
            </div>
          </div>


          <form action="{{ route('petugas.submitemailpasien') }}" method="POST" novalidate>
            @csrf

            <div class="mb-4">
              <label for="email" class="form-label">Email Pasien</label>
              <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Pasien" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex justify-content-center gap-3 mt-5 pt-5">
              <a href="{{ route('register') }}" class="btn btn-outline-primary px-5 rounded-pill">
                Buat Akun Baru
              </a>
              <button type="submit" class="btn btn-primary px-5 rounded-pill">
                Berikutnya
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>

  </div>
</div>
@endsection
 