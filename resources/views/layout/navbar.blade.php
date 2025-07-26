<nav class="w-100 position-relative border-bottom" style="height: 88px;">
  <div class="position-absolute top-0 start-0 p-4">
    <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
  </div>

  <div class="container h-100 d-flex justify-content-end align-items-center">
    <ul class="navbar-nav flex-row gap-4 me-4">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/homepage') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/pasien/homepage') }}">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/tentang') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/pasien/tentang') }}">Tentang Kami</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/pemeriksaan') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/pasien/pemeriksaan') }}">Pemeriksaan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/faq') ? 'active fw-bold text-primary' : '' }}" href="{{ url('/pasien/faq') }}">FAQ</a>
      </li>
    </ul>

    <a href="{{ url('/login') }}" class="btn btn-primary px-4 fw-bold">Masuk</a>
  </div>
</nav>
