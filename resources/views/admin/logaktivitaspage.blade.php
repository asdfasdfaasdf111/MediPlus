<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Admin</title>
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
            <div class="bg-white shadow-sm rounded p-4">
                    <h5 class="fw-bold text-primary mb-3">Log Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jam</th>
                                    <th>Nama Petugas</th>
                                    <th>Aktivitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin->rumahsakit->log as $log)
                                    <tr>
                                        <td>{{ $log->tanggal }}</td>
                                        <td>{{ $log->jam }}</td>
                                        <td>{{ $log->petugas->user->name }}</td>
                                        <td>{{ $log->aktivitas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
{{-- <div>
    Log Aktivitas: 
    <ul>
        @foreach ($admin->rumahsakit->log as $log)
            <li>{{$log}}</li>
        @endforeach
    </ul>
</div> --}}

