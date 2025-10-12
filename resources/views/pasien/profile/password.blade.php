@extends('layout.app')
@section('title', 'Change Password')

@section('content')
<div class="container-fluid">
  <div class="row">

    {{-- Sidebar --}}
    <div class="col-md-2 min-vh-100 p-2 mt-3">
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a href="{{ route('profile.edit') }}"
             class="nav-link {{ request()->routeIs('profile.edit') ? 'text-primary fw-bold' : 'text-dark' }}">
            <i class="bi bi-person-circle me-2"></i> Edit Profile
          </a>
        </li>
        <li class="nav-item mb-2">
          <a href="{{ route('profile.password.edit') }}"
             class="nav-link {{ request()->routeIs('profile.password.*') ? 'text-primary fw-bold' : 'text-dark' }}">
            <i class="bi bi-shield-lock me-2"></i> Change Password
          </a>
        </li>
      </ul>
    </div>

    {{-- Content --}}
    <div class="col-md-10 p-4 bg-light">

      <div class="card shadow-sm">
        <h4 class="text-center mb-1 pt-5">Change Password</h4>
        <p class="text-center text-muted mb-4">Perbarui kata sandi akun Anda</p>

        <form action="{{ route('profile.password.update') }}" method="POST" novalidate>
          @csrf
          @method('PUT')

          <div class="card-body px-5">

            {{-- ================== KEAMANAN ================== --}}
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
