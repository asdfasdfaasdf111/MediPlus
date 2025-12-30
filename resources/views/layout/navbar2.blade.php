<nav class="w-100 border-bottom d-flex justify-content-between align-items-center px-4" style="height: 80px;">
  <div class="d-flex align-items-center">
    <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
  </div>

  <div class="container h-100 d-flex justify-content-end align-items-center">
    <ul class="navbar-nav flex-row gap-4">
      
      @if(Auth::check())
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center fw-bold text-dark"
           href="#" id="userDropdown" role="button"
           data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i>
          Hi, {{ Auth::user()->name }}
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 py-0 overflow-hidden" aria-labelledby="userDropdown">
          
          {{-- Kata GPT biar tida perlu berulang-ulang --}}
          @php
            $route = null;
            if(Auth::user()->petugas) $route = 'petugas.password.edit';
            elseif(Auth::user()->dokter) $route = 'dokter.password.edit';
            elseif(Auth::user()->admin) $route = 'admin.password.edit';
            elseif(Auth::user()->superadmin) $route = 'superadmin.password.edit';
          @endphp

          @if($route)
            <li>
              <a class="dropdown-item py-2 mt-1" href="{{ route($route) }}">
                <i class="bi bi-shield-lock me-2"></i> Ubah Password
              </a>
            </li>
          @endif

          <li><hr class="dropdown-divider m-0"></li>

          <li>
            {{-- Form logout dengan class m-0 agar tidak mendorong space bawah --}}
            <form action="{{ route('logout') }}" method="POST" class="m-0">
              @csrf
              <button type="submit" class="dropdown-item py-2 mb-1 text-danger d-flex align-items-center">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
              </button>
            </form>
          </li>
        </ul>
      </li>
      @endif

    </ul>
  </div>
</nav>