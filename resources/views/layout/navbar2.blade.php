<nav class="w-100 position-relative border-bottom" style="height: 88px;">
  <div class="position-absolute top-0 start-0 p-4">
    <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
  </div>

  <div class="container h-100 d-flex justify-content-end align-items-center">
    <ul class="navbar-nav flex-row gap-4 me-4">

    <li class="nav-item">
          <span class="nav-link">Hi, {{ Auth::user()->name }}</span>
    </li>
    </ul>
  </div>
</nav>

