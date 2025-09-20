<nav class="w-100 border-bottom d-flex justify-content-between align-items-center px-4" style="height: 88px;">
    <!-- Logo kiri -->
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/Mediplus.png') }}" alt="Logo" height="40">
    </div>

    <!-- User kanan -->
    <div class="d-flex flex-row">
        <i class="bi bi-person-circle me-2"></i>
        <span class="nav-link fw-bold">Hi, {{ Auth::user()->name }}</span>
    </div>
</nav>


