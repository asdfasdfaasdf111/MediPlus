<nav class="w-100 position-relative border-bottom" style="height: 88px;">
  <div class="position-absolute top-0 start-0 p-4">
    <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
  </div>

  <div class="container h-100 d-flex justify-content-end align-items-center">
    <ul class="navbar-nav flex-row gap-4 me-4">
      
      {{-- Dropdown User --}}
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-circle me-2"></i>
          Hi, {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
          <li>
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form-admin').submit();">
              <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </div>
</nav>

{{-- Form Logout --}}
<form id="logout-form-admin" action="{{ route('logout') }}" method="POST" style="display: none;">
  @csrf
</form>
