{{-- Mobile --}}
<div class="col-12 d-md-none px-3 pt-3">
  <div class="d-flex flex-wrap gap-2 pb-3">
    <a href="{{ route('profile.edit') }}"
       class="btn btn-sm {{ request()->routeIs('profile.edit') ? 'btn-primary text-white' : 'btn-outline-primary' }}">
      <i class="bi bi-person-circle me-1"></i> Perbarui Profil
    </a>
    <a href="{{ route('profile.password.edit') }}"
       class="btn btn-sm {{ request()->routeIs('profile.password.*') ? 'btn-primary text-white' : 'btn-outline-primary' }}">
      <i class="bi bi-shield-lock me-1"></i> Ubah Kata Sandi
    </a>
  </div>
</div>


{{-- Desktop --}}
<div class="col-md-2 p-2 mt-3 d-none d-md-block">
  <div class="min-vh-100">
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="{{ route('profile.edit') }}"
           class="nav-link {{ request()->routeIs('profile.edit') ? 'text-primary fw-bold' : 'text-dark' }}">
          <i class="bi bi-person-circle me-2"></i> Perbarui Profil
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="{{ route('profile.password.edit') }}"
           class="nav-link {{ request()->routeIs('profile.password.*') ? 'text-primary fw-bold' : 'text-dark' }}">
          <i class="bi bi-shield-lock me-2"></i> Ubah Kata Sandi
        </a>
      </li>
    </ul>
  </div>
</div>
