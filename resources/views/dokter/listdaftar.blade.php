<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List Draft Laporan</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    @include('layout.navbar2')

    <style>
        .text-wrap {
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        max-height: 200px;
        overflow-y: auto;
        }

        .content-wrapper {
            background-color: #eef4ff;
            min-height: 90vh;
            justify-content: center;
            padding: 1.5rem 2rem;
        }
    </style>

    <div class="content-wrapper">
        <div class="container mt-4">
        <div class="d-flex flex-row justify-content-between pb-2">
            <a href="{{ route('dokter.homepage') }}" class="mt-3 ps-4" style="color: grey">Kembali</a>
            <h3 class="mb-0 fw-bold text-center" style="color: #012970; font-family: 'Open Sans', sans-serif;">List Draft</h3>
            <p class=""> </p>
        </div>

        <div class="d-flex flex-column">
            <div class="" style="background-color: #eef4ff;">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="flex-grow-1 p-4">
                        <form action="" class="form-inline my-3 my-lg-0" method="GET">
                            <div class="input-group">
                                <input class="form-control form-control-sm w-auto" type="text" name="search" placeholder="Cari Draft" style="font-family: 'Open Sans', sans-serif;">
                                <button class="btn btn-outline-secondary" type="submit" style="background-color: #ffff">
                                <i class="bi bi-search" style="background-color: #ffff"></i>
                            </div>
                        </form>
                    </div>
                <div class="col-md-2 p-2">
                    <form action="{{ route('dokter.addnew') }}" method="GET">
                        <button type="submit" class="btn btn-primary w-100 fw-bold px-3">+ Tambah Draft Baru</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="">
            @if($drafts->isEmpty())
                <p class="">Tidak ada data.</p>
            @else
                @foreach($drafts as $draft)
                    <div class="bg-white shadow-sm rounded p-3 mb-3">
                        <strong class="">{{ $draft->judul }}</strong><br>
                        <hr class="my-2">
                        <p class="text-wrap">{{ $draft->deskripsi }}</p>

                        <div class="d-flex flex-row-reverse gap-2 align-items-right">
                            <form action="{{ route('dokter.delete', $draft->id)}}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <div class="input group rounded justify-content-around" style="background-color: #dc3545">
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-trash"></i>
                                    <span>Hapus</span>
                                </button>
                                </div>
                            </form>

                            <form action="{{ route('dokter.edit', $draft) }}" method="GET" style="display:inline;">
                                <div class="input group rounded" style="background-color: #1A76D1;">
                                    <button type="submit" class="btn btn-sm d-flex align-items-center gap-2" style="color: white">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                @endforeach
            @endif
        </div>
    </div>
        </div>
    </div>
</body>
</html>
