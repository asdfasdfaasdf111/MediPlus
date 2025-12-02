<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - Mediplus</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark">

<div class="container-fluid vh-100">
  <div class="row h-100">

    <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center">
      <div class="position-absolute top-0 start-0 p-4">
        <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
      </div>
      <img src="{{ asset('images/LoginPageHospital.jpg') }}" alt="Hospital Illustration" class="img-fluid px-5">
    </div>

    {{-- Kanan: Form --}}
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="w-75">

        <h2 class="fw-bold mb-2 text-primary">Reset Password</h2>
        <p class="text-muted mb-4">
          Silahkan masukkan password baru.
        </p>

        <form method="POST" action="{{ route('password.update') }}">
          @csrf

          <input type="hidden" name="token" value="{{ $token }}">

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ $email ?? old('email') }}"
                   required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required
                   minlength="8"
                   placeholder="Minimal 8 karakter">
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-4">
            <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   class="form-control"
                   required
                   minlength="8"
                   placeholder="Ulangi password baru">
          </div>

          <button type="submit" class="btn btn-primary w-100 mb-3">
            Simpan Password Baru
          </button>

          <div>
            <a href="{{ route('login') }}" class="small text-decoration-none">
              <i class="bi bi-arrow-left"></i> Kembali ke halaman login
            </a>
          </div>
        </form>

      </div>
    </div>

  </div>
</div>

<script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
