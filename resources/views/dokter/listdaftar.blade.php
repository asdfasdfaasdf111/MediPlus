<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Draft Laporan</title>

    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-white text-dark">
    @include('layout.navbar2')

    <div class="min-vh-100 py-4 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3 ms-4 me-4">
            <a href="{{ route('dokter.homepage') }}" class="text-muted text-decoration-none small">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>

            <span class="small opacity-0">
                <i class="bi bi-arrow-left"></i> Kembali
            </span>
        </div>

        <div class="d-flex align-items-center gap-3 flex-wrap mb-3 ms-4 me-4 ">
            <form id="draftSearchForm" class="flex-grow-1" onsubmit="return false;">
                <div class="input-group">
                    <input id="draftSearch" class="form-control form-control-sm" type="text" placeholder="Cari Draft">
                    <button class="btn btn-outline-secondary" type="button">
                    <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>


            <form action="{{ route('dokter.addnew') }}" method="GET">
                <button type="submit" class="btn btn-primary fw-bold px-3 d-inline-flex align-items-center gap-2">
                    <span>
                        <i class="bi bi-plus"></i>
                        Tambah Draft Baru
                    </span>
                </button>
            </form>
        </div>

        <div class="ms-4 me-4">
            @if($drafts->isEmpty())
                <p class="text-muted text-center py-3 mb-0">Tidak ada data.</p>
            @else
                @foreach($drafts as $draft)
                    <div class="card border-0 shadow-sm mb-3 draft-item">
                        <div class="card-body">
                            <strong class="d-block mb-1">{{ $draft->judul }}</strong>
                            <hr class="my-2">
                            <p class="mb-3 text-break overflow-auto text-start" style="max-height: 200px; white-space: pre-wrap;">{{ $draft->deskripsi }}
                            </p>

                            <div class="d-flex justify-content-end gap-2">

                                <form action="{{ route('dokter.edit', $draft) }}" method="GET">
                                    <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-2" color:white;">
                                        <i class="bi bi-pencil-square"></i>
                                        <span>Edit</span>
                                    </button>
                                </form>
                                <form action="{{ route('dokter.delete', $draft->id)}}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center gap-2">
                                        <i class="bi bi-trash"></i>
                                        <span>Hapus</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    
    <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
    @vite(['resources/js/searchlistdraft.js'])
</body>
</html>
