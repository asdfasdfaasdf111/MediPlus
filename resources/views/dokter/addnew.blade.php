<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Draft</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body class="bg-white text-dark" style="font-family: 'Open Sans', sans-serif;">
    @include('layout.navbar2')

    <style>
        .content-wrapper {
            background-color: #f8f9fa; 
            min-height: 90vh;
            justify-content: center;
            padding: 1.5rem 2rem;
        }

        input.form-control {
            height: 40px;
            font-size: 15px;
            padding: 6px 10px;
        }
    </style>

    <div class="content-wrapper bg-light">
        <div class="bg-white p-5 pt-4 pb-4 rounded m-5 mt-4 mb-4 shadow-sm">

            <form action="{{ route('dokter.submit') }}" method="POST" novalidate>
                @csrf

                <h3 class="mb-0 fw-bold text-center" style="color: #012970;">Draft</h3>

                <div class="form-group d-flex flex-column mt-3">
                    <label class="fw-semibold" for="judul">Judul Draft</label>
                    <input
                        type="text"
                        id="judul"
                        name="judul"
                        class="form-control form-control-lg"
                        placeholder="Judul Draft"
                        value="{{ old('judul') }}"
                    >
                    @error('judul')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3">
                    <label class="fw-semibold" for="deskripsi">Deskripsi Draft</label>
                    <textarea
                        name="deskripsi"
                        id="deskripsi"
                        class="form-control"
                        rows="10"
                        placeholder="Deskripsi"
                    >{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-center gap-3 pt-3">
                    <a href="{{ route('dokter.listdaftar') }}"
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

    <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
