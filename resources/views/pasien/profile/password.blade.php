@extends('layout.app')
@section('title', 'Change Password')

@section('content')
<div class="container-fluid">
  <div class="row">

    @include('layout.sidebar')

    {{-- Content --}}
    <div class="col-md-10 p-4 bg-light">

            {{-- Alert Success --}}
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-1 mx-md-0 mt-2" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      
      <div class="card shadow-sm">
        <h4 class="text-center mb-1 pt-5">Ubah Kata Sandi</h4>
        <p class="text-center text-muted mb-4">Perbarui kata sandi akun Anda</p>

        <form action="{{ route('profile.password.update') }}" method="POST" novalidate>
          @csrf
          @method('PUT')

          <div class="card-body px-5">

            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-shield-lock me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Keamanan</h6>
              </div>

              {{-- Password Saat Ini --}}
              <div class="mt-3 mb-3">
                <label class="form-label">Password Saat Ini</label>
                <input type="password"
                       name="current_password"
                       required
                       autocomplete="current-password"
                       placeholder="Masukkan password saat ini"
                       class="form-control @error('current_password') is-invalid @enderror">
                @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Password Baru --}}
              <div class="mb-3">
                <label class="form-label">Password Baru</label>
                <input type="password"
                       name="password"
                       required
                       minlength="8"
                       autocomplete="new-password"
                       placeholder="Minimal 8 karakter"
                       class="form-control @error('password') is-invalid @enderror">
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>

              {{-- Konfirmasi Password Baru --}}
              <div class="mb-1">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password"
                       name="password_confirmation"
                       required
                       minlength="8"
                       autocomplete="new-password"
                       placeholder="Ulangi password baru"
                       class="form-control">
              </div>
            </div>
          </div>

          {{-- Footer tombol aksi --}}
          <div class="card-footer bg-white border-0 py-3">
            <div class="d-flex justify-content-center gap-3">
              <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary px-5 rounded-pill">Kembali</a>
              <button type="submit" class="btn btn-primary px-5 rounded-pill">Simpan Password</button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
@endsection
