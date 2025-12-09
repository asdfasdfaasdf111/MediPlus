<nav class="w-100 border-bottom d-flex justify-content-between align-items-center px-4" style="height: 88px;">
    <!-- Logo kiri -->
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
    </div>

  <div class="container h-100 d-flex justify-content-end align-items-center">
    <ul class="navbar-nav flex-row gap-4 me-4">
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center"
           href="#" id="userDropdown" role="button"
           data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i>
          Hi, {{ Auth::user()->name }}
        </a>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
          @if(Auth::user()->petugas)
            <li>
              <a class="dropdown-item" href="{{ route('petugas.password.edit') }}">
                <i class="bi bi-shield-lock me-2"></i> Ubah Password
              </a>
            </li>
          @elseif(Auth::user()->dokter)
            <li>
              <a class="dropdown-item" href="{{ route('dokter.password.edit') }}">
                <i class="bi bi-shield-lock me-2"></i> Ubah Password
              </a>
            </li>
          @endif

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
  </div>
</nav>

