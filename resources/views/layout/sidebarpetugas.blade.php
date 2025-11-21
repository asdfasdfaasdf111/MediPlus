<div class="col-md-2 min-vh-100 p-3 border-end">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('petugas.dashboard') }}"
               class="nav-link {{ request()->routeIs(['petugas.dashboard','petugas.pratinjaupemeriksaan', 'petugas.detailpemeriksaan', 'petugas.editpendaftaran']) ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolajenispemeriksaan') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolajenispemeriksaan','petugas.tambahjenispemeriksaanpage') ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-clipboard2-check me-2"></i> Jenis Pemeriksaan
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('petugas.kelolamodalitas') }}"
               class="nav-link {{ request()->routeIs('petugas.kelolamodalitas','petugas.tambahmodalitaspage') ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-hdd-rack me-2"></i> Modalitas
            </a>
        </li>

    </ul>
</div>
