<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Superadmin</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    @include('layout.navbar2')

    <style>
        .content-wrapper {
            background-color: #eef4ff;
            min-height: 100vh;
        }

        h6, p, button, span, small {
            font-family: 'Open Sans', sans-serif;
        }
    </style>

    <div class="content-wrapper">
        <div class="" style="background-color: #eef4ff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="flex-grow-1 p-4">
                <form action="" class="form-inline my-2 my-lg-0" method="GET">
                    <div class="input-group">
                        <input class="form-control form-control-sm w-auto" type="text" name="search" placeholder="Cari Rumah Sakit" style="font-family: 'Open Sans', sans-serif;">
                        <button class="btn btn-outline-secondary" type="submit" style="background-color: #ffff">
                        <i class="bi bi-search" style="background-color: #ffff"></i>
                    </div>
                </form>
            </div>
            <div class="col-md-2 p-4">
                <form action="{{ route('superadmin.addnew') }}" method="GET">
                    <button type="submit" class="btn btn-primary w-100 fw-bold px-3">+ Tambah RS Baru</button>
                </form>
            </div>
        </div>

        <div class="mt-3">
                @if($totalRS === 0)
                    <p class="">Belum ada rumah sakit yang terdaftar</p>
                @elseif($rumahSakits->isEmpty())
                    <div class="text-center">
                        <h6>Data tidak ditemukan untuk pencarian <strong>'{{ request('search') }}'</strong></h6>
                    </div>
                @else
                    <div class="row me-3 ms-3">
                        @foreach ($rumahSakits as $rs)
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <div class="bg-white shadow-sm rounded p-3">
                                    <div class="d-flex align-items-center mb-2 mt-3">
                                        <img src="{{ asset('images/gambar_rumah_sakit.jpg') }}" alt="Foto RS" class="rounded-circle me-3" width="50" height="50">
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $rs->nama }}</h6>
                                            <p class="">{{ $rs->alamat }}</p><br>
                                            <p class="">{{ $rs->noTelepon }}</p>
                                        </div>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                                        <small class="text-muted me-auto p-2">ID: {{ $rs->id }} </small>
                                        <div class="d-flex gap-2">
                                            <form action="{{ route('superadmin.edit', $rs) }}" method="GET" style="display:inline;">
                                                <div class="input group rounded" style="background-color: #ffc107">
                                                <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-2">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Edit</span>
                                                </button>
                                                </div>
                                            </form>
                                            <form action="{{ route('superadmin.delete', $rs->id)}}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <div class="input group rounded justify-content-around" style="background-color: #dc3545">
                                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                                                        <i class="bi bi-trash"></i>
                                                        <span>Hapus</span>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
        </div>
    </div>
    </div>
</body>
</html>


