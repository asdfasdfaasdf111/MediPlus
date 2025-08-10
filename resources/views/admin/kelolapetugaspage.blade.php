<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Petugas</title>
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
            {{-- Header atas: Search + Tambah Akun --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="flex-grow-1 me-3">
                    <form action="" method="GET"> 
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Cari Petugas">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.tambahakunpetugaspage') }}" class="btn btn-primary w-100">
                        <i class="bi bi-plus"></i> Tambah Akun
                    </a>
                </div>
            </div>

        {{-- Daftar Petugas --}}
        @foreach ($admin->rumahsakit->petugas as $ptg)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="bg-white shadow-sm rounded p-3">
                    <div class="d-flex align-items-center mb-2">
                        <img src="{{ asset('images/user-icon.png') }}" alt="Foto Petugas" class="rounded-circle me-3" width="50" height="50">
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $ptg->user->name }}</h6>
                            <small class="text-muted">{{ $ptg->user->email }}</small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Id: {{ $ptg->id }}</small>
                        <form action="{{ route('admin.hapusAkunPetugas', $ptg->user->id) }}" method="POST" onsubmit="return confirm('Apakah anda yakin ingin menghapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
