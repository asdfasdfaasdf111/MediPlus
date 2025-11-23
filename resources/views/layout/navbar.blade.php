<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">

    {{-- LOGO / BRAND --}}
    <a class="navbar-brand d-flex align-items-center" href="{{ url('/pasien/homepage') }}">
      <img src="{{ asset('images/Mediplus.png') }}" alt="Logo MediPlus" height="36" class="me-2">
    </a>

    {{-- BUTTON HAMBURGER buat mobile --}}
    <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#pasienNavbar"
            aria-controls="pasienNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="pasienNavbar">

      {{-- MENU mobile--}}
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 w-100 w-lg-auto">
        <li class="nav-item border-top d-lg-none">
          <a class="nav-link text-center text-lg-start py-2 {{ request()->is('pasien/homepage') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/homepage') }}">
            Beranda
          </a>
        </li>
        <li class="nav-item border-top d-lg-none">
          <a class="nav-link text-center text-lg-start py-2 {{ request()->is('pasien/tentangkami') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/tentangkami') }}">
            Tentang Kami
          </a>
        </li>
        <li class="nav-item border-top d-lg-none">
          <a class="nav-link text-center text-lg-start py-2 {{ request()->is('pasien/pendaftaran') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/pendaftaran') }}">
            Pemeriksaan
          </a>
        </li>
        <li class="nav-item border-top d-lg-none">
          <a class="nav-link text-center text-lg-start py-2 {{ request()->is('pasien/faq') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/faq') }}">
            FAQ
          </a>
        </li>

        {{-- MENU desktop--}}
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link {{ request()->is('pasien/homepage') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/homepage') }}">
            Beranda
          </a>
        </li>
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link {{ request()->is('pasien/tentangkami') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/tentangkami') }}">
            Tentang Kami
          </a>
        </li>
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link {{ request()->is('pasien/pendaftaran') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/pendaftaran') }}">
            Pemeriksaan
          </a>
        </li>
        <li class="nav-item d-none d-lg-block">
          <a class="nav-link {{ request()->is('pasien/faq') ? 'active fw-bold text-primary' : '' }}"
             href="{{ url('/pasien/faq') }}">
            FAQ
          </a>
        </li>

        {{-- Versi Mobile Profile--}}
        @if(Auth::check())
          <li class="nav-item border-top d-lg-none">
            <a class="nav-link text-center py-2 {{ request()->routeIs('profile.*') ? 'active fw-bold text-primary' : '' }}"
              href="{{ route('profile.edit') }}">
              <i class="bi bi-person-circle me-1"></i> Profil Saya
            </a>
          </li>
          <li class="nav-item border-top d-lg-none">
            <form action="{{ route('logout') }}" method="POST" class="d-block">
              @csrf
              <button type="submit"
                      class="nav-link text-center py-2 border-0 bg-transparent w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Keluar
              </button>
            </form>
          </li>
        @else
          <li class="nav-item border-top d-lg-none">
            <a href="{{ url('/login') }}"
               class="nav-link text-center py-2">
              Masuk
            </a>
          </li>
        @endif
      </ul>

      {{-- Versi Desktop Profile --}}
      @if(Auth::check())
        <ul class="navbar-nav ms-lg-3 d-none d-lg-flex">
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
        <div class="ms-lg-3 mt-2 mt-lg-0 d-none d-lg-block">
          <a href="{{ url('/login') }}" class="btn btn-primary px-4 fw-bold">
            Masuk
          </a>
        </div>
      @endif

    </div>
  </div>
</nav>
