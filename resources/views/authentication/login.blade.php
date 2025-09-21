<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Mediplus</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="bg-white text-dark">

  <div class="container-fluid">
    <div class="row vh-100">
      
      <div class="col-md-6 d-none d-md-flex flex-column justify-content-center align-items-center">
        <div class="position-absolute top-0 start-0 p-4">
          <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
        </div>
        <img src="{{ asset('images/LoginPageHospital.jpg') }}" alt="Hospital Illustration" class="img-fluid px-5">
      </div>

      <div class="col-md-6 d-flex align-items-center justify-content-center">
        <div class="w-75">
          <h2 class="fw-bold mb-2 text-primary">Selamat Datang!</h2>
          <p class="mb-4 text-muted">Silahkan masuk ke dalam akun Anda.</p>

          <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
              @error('email')
                <div class="invalid-feedback">Email tidak terdaftar</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
              @error('password')
                <div class="invalid-feedback">Password salah</div>
              @enderror
            </div>

            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="remember" name="remember">
              <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>

            <div class="d-grid mb-3">
              <button type="submit" class="btn btn-primary">Masuk</button>
            </div>

            <div class="text-center">
              Belum punya akun? 
              <a href="{{ route('register') }}">Buat Akun</a>
            </div>
          </form>
        </div>
      </div>

    </div>
  </div>

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
