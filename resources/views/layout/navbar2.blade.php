<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="/logo.png" alt="Mediplus Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
      <strong>Mediplus</strong>
    </a>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <span class="nav-link">Hi, {{ Auth::user()->name }}</span>
        </li>
      </ul>
    </div>
  </div>
</nav>
