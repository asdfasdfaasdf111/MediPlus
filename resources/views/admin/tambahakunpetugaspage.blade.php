<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Admin</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Jadwal</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<body class="bg-white text-dark" style="height: 100vh; overflow: hidden;">

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
                    <a href="{{ route('admin.keloladokterpage') }}" class="nav-link {{ request()->routeIs('admin.keloladokterpage', 'admin.tambahakundokterpage') ? 'text-primary fw-bold' : 'text-dark' }}">
                        <i class="bi bi-person-badge me-2"></i> Kelola Akun Dokter
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('admin.kelolapetugaspage') }}" class="nav-link {{ request()->routeIs('admin.kelolapetugaspage', 'admin.tambahakunpetugaspage') ? 'text-primary fw-bold' : 'text-dark' }}">
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
            <div class="card shadow-sm">
                <h4 class="text-center mb-4 pt-5">Tambah Akun Petugas</h4>
                <div class="card-body px-5">
                <form method="POST" action="{{ route('admin.tambahAkunPetugas') }}">
                    @csrf
                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                            name="name" id="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" id="email" placeholder="Email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" id="password" placeholder="Password" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4"">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" 
                            name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="d-flex justify-content-center gap-3 pt-3">
                        <a href="{{ route('admin.keloladokterpage') }}" 
                           class="btn btn-outline-primary px-5 rounded-pill">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>
