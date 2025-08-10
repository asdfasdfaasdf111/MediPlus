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


<form action="{{ route('admin.updateJadwal')}}" method ="POST">
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

