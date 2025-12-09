@extends('layout.staff')
@section('title', 'Ubah Password')

@section('content')

     @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-1 mx-md-0 mt-2" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

<div class="container-fluid bg-light py-5">
  <div class="row">
    <div class="col-md-10 p-4 mx-auto">

      <div class="card shadow-sm">
        <h4 class="text-center mb-1 pt-5">Ubah Kata Sandi</h4>
        <p class="text-center text-muted mb-4">Perbarui kata sandi</p>

        <div class="card-body px-5">
          <form action="{{ route('dokter.password.update') }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-shield-lock me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Keamanan</h6>
              </div>

              {{-- Password Saat Ini --}}
              <div class="mt-3 mb-3">
                <label for="current_password" class="form-label">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required autocomplete="current-password" placeholder="Masukkan password saat ini" class="form-control @error('current_password') is-invalid @enderror">
                @error('current_password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Password Baru --}}
              <div class="mb-3">
                <label for="password" class="form-label">Password Baru</label>
                <input type="password" id="password" name="password" required minlength="8" autocomplete="new-password" placeholder="Minimal 8 karakter" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Konfirmasi Password Baru --}}
              <div class="mb-1">
                <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required minlength="8" autocomplete="new-password" placeholder="Konfirmasi Password Baru" class="form-control @error('password_confirmation') is-invalid @enderror">
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-center gap-3 pt-4 pb-4">
              <a href="{{ route('dokter.homepage') }}" class="btn btn-outline-primary px-5 rounded-pill">Kembali</a>
              <button type="submit" class="btn btn-primary px-5 rounded-pill">Perbarui</button>
            </div>

          </form>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
