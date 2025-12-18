<div class="col-md-2 min-vh-100 p-3 border-end">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('dokter.homepage') }}"
               class="nav-link {{ request()->routeIs(['dokter.homepage','dokter.addnew', 'dokter.detailpemeriksaan', 'dokter.edit', 'dokter.listdaftar']) ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-speedometer2 me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('dokter.ubahjadwalkerja') }}"
               class="nav-link {{ request()->routeIs('dokter.ubahjadwalkerja') ? 'text-primary fw-bold' : 'text-dark' }}">
                <i class="bi bi-clipboard2-check me-2"></i> Jadwal Kerja
            </a>
        </li>
    </ul>
</div>
