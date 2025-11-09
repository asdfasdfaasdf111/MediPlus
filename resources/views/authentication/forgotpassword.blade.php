<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lupa Password - Mediplus</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark">

<div class="container-fluid vh-100">
  <div class="row h-100">

    {{-- Kiri: Gambar --}}
    <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center">
      <div class="position-absolute top-0 start-0 p-4">
        <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
      </div>
      <img src="{{ asset('images/LoginPageHospital.jpg') }}" alt="Hospital Illustration" class="img-fluid px-5">
    </div>

    {{-- Kanan: Form --}}
    <div class="col-md-6 d-flex align-items-center justify-content-center">
      <div class="w-75">

        <h2 class="fw-bold mb-2 text-primary">Lupa Password</h2>
        <p class="text-muted mb-4">
          Masukkan email yang terdaftar. Jika sesuai, kami akan mengirimkan link untuk mengatur ulang password Anda.
        </p>

        {{-- Alert sukses/status --}}
        @if (session('status'))
          <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
          @csrf

          <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}"
                   placeholder="Email yang terdaftar"
                   required
                   autofocus>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <button type="submit" class="btn btn-primary w-100 mb-3">
            Kirim Link Reset Password
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
