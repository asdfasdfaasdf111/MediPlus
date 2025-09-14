<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="bg-white text-dark">

    @include('layout.navbar2')

<div class="container-fluid">
    <div class="row">

        {{-- Sidebar --}}
        <div class="col-md-2 min-vh-100 p-2 mt-3">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.homepage') }}" class="nav-link {{ request()->routeIs('admin.homepage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-calendar-week me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.keloladokterpage') }}" class="nav-link {{ request()->routeIs('admin.keloladokterpage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-person-badge me-2"></i> Kelola Akun Dokter
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.kelolapetugaspage') }}" class="nav-link {{ request()->routeIs('admin.kelolapetugaspage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-person-lines-fill me-2"></i> Kelola Akun Petugas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.kelolajadwalpage') }}" class="nav-link {{ request()->routeIs('admin.kelolajadwalpage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-calendar-check me-2"></i> Kelola Jadwal
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.logaktivitaspage') }}" class="nav-link {{ request()->routeIs('admin.logaktivitaspage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-file-earmark-text me-2"></i> Log Aktivitas
                    </a>
                </li>
            </ul>
        </div>

<div class="col-md-10 p-4 bg-light">

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        {{-- Card: Jam Operasional --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Jam Operasional</span>
                    <span class="badge bg-secondary">
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamBuka)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamTutup)->format('H:i') }}
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.updateJadwal') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="jamBuka" class="form-label">Jam Buka</label>
                            <input
                                type="time"
                                name="jamBuka"
                                id="jamBuka"
                                value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamBuka)->format('H:i') }}"
                                class="form-control @error('jamBuka') is-invalid @enderror"
                                required
                            >
                            @error('jamBuka')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="jamTutup" class="form-label">Jam Tutup</label>
                            <input
                                type="time"
                                name="jamTutup"
                                id="jamTutup"
                                value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamTutup)->format('H:i') }}"
                                class="form-control @error('jamTutup') is-invalid @enderror"
                                required
                            >
                            @error('jamTutup')
                                <div class="invalid-feedback">Jam tutup harus di atas jam buka</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Update Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Card: Kuota Pasien / Jam --}}
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Kuota Pasien</span>
                    <span class="badge bg-secondary">{{ $admin->rumahSakit->jumlahPasien }} pasien</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.updateJumlahPasien') }}" method="POST" class="row g-3">
                        @csrf
                        <div class="col-12">
                            <label for="jumlahPasien" class="form-label">Jumlah Pasien / 1 Jam</label>
                            <input
                                type="number"
                                name="jumlahPasien"
                                id="jumlahPasien"
                                min="1"
                                step="1"
                                value="{{ $admin->rumahSakit->jumlahPasien }}"
                                class="form-control @error('jumlahPasien') is-invalid @enderror"
                                required
                            >
                            <div class="form-text">Masukkan angka positif (contoh: 6).</div>
                            @error('jumlahPasien')
                                <div class="invalid-feedback">Jumlah Pasien harus positif</div>
                            @enderror
                        </div>

                        <div class="col-12 d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                Update Kuota
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Ringkasan (Opsional) --}}
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="alert alert-info mb-0" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle me-2"></i>
                            <div>
                                Jadwal dan kuota ini akan digunakan dalam pembuatan slot konsultasi dokter sesuai kebijakan rumah sakit.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
<script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>


            {{-- <form action="{{ route('admin.updateJadwal')}}" method ="POST">
                @csrf
                <div>
                    <label for='jamBuka'>Jam Buka</label>
                    <input type='time' name='jamBuka' id='jamBuka' value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamBuka)->format('H:i') }}"   required>
                </div>

                <div>
                    <label for='jamTutup'>Jam Tutup</label>
                    <input type='time' name='jamTutup' id='jamTutup' value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $admin->rumahSakit->jamTutup)->format('H:i') }}"   required>
                    @error('jamTutup')
                        <div style="color: red;">{{ "Jam tutup harus diatas jam buka" }}</div>
                    @enderror
                </div>

                <button type='submit'>Update Jadwal</button>
            </form>

            <form action="{{ route('admin.updateJumlahPasien')}}" method ="POST">
                @csrf
                <div>
                    <label for='jumlahPasien'>Jumlah Pasien / 1 jam</label>
                    <input type='number' name='jumlahPasien' id='jumlahPasien' value="{{ $admin->rumahSakit->jumlahPasien }}"   required>
                    @error('jumlahPasien')
                        <div style="color: red;">{{ "Jumlah Pasien harus positif" }}</div>
                    @enderror
                </div>

                <button type='submit'>Update Jumlah Pasien</button>
            </form>
         --}}
        </div>
