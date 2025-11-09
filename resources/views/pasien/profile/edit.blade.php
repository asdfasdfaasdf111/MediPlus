@extends('layout.app')
@section('title', 'Edit Profile')

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

      {{-- Alert Success --}}
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mx-1 mx-md-0 mt-2" role="alert">
          <i class="bi bi-check-circle-fill me-2"></i>
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif


      <div class="card shadow-sm">
        <h4 class="text-center mb-1 pt-5">Edit Profile</h4>
        <p class="text-center text-muted mb-4">Perbarui data akun dan informasi pasien</p>

        <div class="card-body px-5">
          <form action="{{ route('profile.update') }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            {{-- ================== AKUN ================== --}}
            <div class="mb-4">
              <div class="d-flex align-items-center">
                <i class="bi bi-person-badge me-2"></i>
                <h6 class="mb-0 text-uppercase text-muted">Akun</h6>
              </div>
              <div class="mt-3 row g-3">
                <div class="col-12">
                  <label for="name" class="form-label">Nama</label>
                  <input type="text" id="name" name="name" maxlength="100" required
                         class="form-control @error('name') is-invalid @enderror"
                         placeholder="Nama lengkap"
                         value="{{ old('name', $user->name) }}">
                  @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" id="email" name="email" required
                         class="form-control @error('email') is-invalid @enderror"
                         placeholder="email@domain.com"
                         value="{{ old('email', $user->email) }}">
                  @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
              </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="d-flex justify-content-center gap-3 pt-4">
              <a href="{{ route('pasien.homepage') }}" class="btn btn-outline-primary px-5 rounded-pill">Kembali</a>
              <button type="submit" class="btn btn-primary px-5 rounded-pill">Simpan</button>
            </div>
          </form>
        </div>
      </div>

      

    </div>
  </div>
</div>
@endsection
