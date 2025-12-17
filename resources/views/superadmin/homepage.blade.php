<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Superadmin</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    @include('layout.navbar2')

    <style>
        /* .content-wrapper {
            min-height: 100vh;
        } */

        h6, p, button, span, small {
            font-family: 'Open Sans', sans-serif;
        }
    </style>

    <div class="content-wrapper bg-light min-vh-100">
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
                    <button type="submit" class="btn btn-primary w-100 fw-bold px-3">
                      <i class="bi bi-plus me-2"></i> Tambah RS Baru
                    </button>
                </form>
            </div>
        </div>

       @if(session('success'))
            <div id="successAlert" class="alert alert-success alert-dismissible fade show mx-4 mt-2" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            {{-- Auto tutup alert abis 3 detik --}}
            <script>
                setTimeout(() => {
                const el = document.getElementById('successAlert');
                if (el) bootstrap.Alert.getOrCreateInstance(el).close();
                }, 3000);
            </script>
        @endif



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
                            <div class="col-12 col-md-6 col-lg-4 mb-4 d-flex">
                                <div class="bg-white shadow-sm rounded p-3 w-100 h-100 d-flex flex-column">
                                    {{-- HEADER + ISI CARD --}}
                                    <div class="d-flex align-items-center mb-2 mt-3">
                                        <img src="{{ asset('images/gambar_rumah_sakit.jpg') }}"
                                            alt="Foto RS"
                                            class="rounded-circle me-3"
                                            width="50" height="50">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $rs->nama }}</h6>
                                            <p class="mb-1">{{ $rs->alamat }}</p>
                                            <p class="mb-0">{{ $rs->noTelepon }}</p>
                                        </div>
                                    </div>


                                    {{-- FOOTER CARD  --}}
                                    <div class="mt-auto">
                                    {{-- GARIS PEMBATAS --}}
                                    <hr class="my-2">

                                        <div class="d-flex justify-content-end gap-2 pt-3 pb-2">
                                            <form action="{{ route('superadmin.edit', $rs) }}"
                                                method="GET" style="display:inline;">
                                                <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-2">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Edit</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('superadmin.delete', $rs->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                                                    <i class="bi bi-trash"></i>
                                                    <span>Hapus</span>
                                                </button>
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
</body>

{{-- Izin tambahin soalny button "Superadmin" gabs diclick --}}
<script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</html>


