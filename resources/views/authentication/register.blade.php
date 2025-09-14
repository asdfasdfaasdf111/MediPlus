<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Mediplus</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark">

  <div class="container-fluid vh-100">
    <div class="row h-100">

      {{-- Gambar RS --}}
      <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center">
        <div class="position-absolute top-0 start-0 p-4">
          <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
        </div>
        <img src="{{ asset('images/LoginPageHospital.jpg') }}" alt="Hospital Illustration" class="img-fluid px-5">
      </div>

      {{-- Form --}}
      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="w-75">

          <h2 class="fw-bold mb-2 text-primary">Daftar Akun</h2>
          <p class="text-muted mb-4">Silakan isi formulir di bawah ini untuk membuat akun baru.</p>

          <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Nama</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" required>
              @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ old('email') }}" required>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="noHP" class="form-label">No. Handphone</label>
              <input type="tel" class="form-control @error('noHP') is-invalid @enderror" name="noHP" id="noHP" value="{{ old('noHP') }}" required>
              @error('noHP')
                <div class="invalid-feedback">
                  Nomor HP harus dimulai dengan angka 08 dan berisi 10-13 digit.
                </div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" required>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
              <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
            </div>

            {{-- Terms --}}
            <div class="form-check mb-3">
              <input class="form-check-input" type="checkbox" id="terms" required>
              <label class="form-check-label" for="terms">
                Saya menyetujui <a href="#">Syarat dan Ketentuan</a> serta <a href="#">Kebijakan Privasi</a>
              </label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Daftar</button>

            <div class="text-center mt-3">
              Sudah punya akun? 
              <a href="{{ route('login') }}">Login</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
