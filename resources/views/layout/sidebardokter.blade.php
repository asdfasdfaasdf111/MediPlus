<div class="col-md-2 min-vh-100 p-3 border-end">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('dokter.homepage') }}"
               class="nav-link {{ request()->routeIs(['dokter.homepage','dokter.detailpemeriksaan']) ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-speedometer2 me-2"></i> Homepage
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('dokter.listdaftar') }}"
               class="nav-link {{ request()->routeIs('dokter.listdaftar') ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-clipboard2-check me-2"></i> List Draft
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('dokter.ubahjadwalkerja') }}"
               class="nav-link {{ request()->routeIs('dokter.ubahjadwalkerja') ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-hdd-rack me-2"></i> Ubah Jadwal
            </a>
        </li>

    </ul>
</div>
