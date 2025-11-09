{{-- INI AKU MAU COBA --}}
<nav class="w-100 position-relative border-0" style="height: 88px;">
  <div class="position-absolute top-0 start-0 p-4">
    <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
  </div>

  <div class="container h-100 d-flex justify-content-end align-items-center">
    {{-- Menu Utama Pasien --}}
    <ul class="navbar-nav flex-row gap-4 me-4">
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/homepage') ? 'active fw-bold text-primary' : '' }}" 
           href="{{ url('/pasien/homepage') }}">Beranda</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/tentangkami') ? 'active fw-bold text-primary' : '' }}" 
           href="{{ url('/pasien/tentangkami') }}">Tentang Kami</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/pendaftaran') ? 'active fw-bold text-primary' : '' }}" 
           href="{{ url('/pasien/pendaftaran') }}">Pemeriksaan</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->is('pasien/faq') ? 'active fw-bold text-primary' : '' }}" 
           href="{{ url('/pasien/faq') }}">FAQ</a>
      </li>
    </ul>

    {{-- Dropdown User --}}
    @if(Auth::check())
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-bold text-dark d-flex align-items-center"
             href="#" id="userDropdown" role="button"
             data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle me-2" style="font-size: 1.2rem;"></i>
            Hi, {{ Auth::user()->name }}
          </a>

          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item" href="{{ route('profile.edit') }}">
                <i class="bi bi-pencil-square me-2"></i> Edit Profil
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item">
                  <i class="bi bi-box-arrow-right me-2"></i> Keluar
                </button>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    @else
      <a href="{{ url('/login') }}" class="btn btn-primary px-4 fw-bold">Masuk</a>
    @endif
  </div>
</nav>

