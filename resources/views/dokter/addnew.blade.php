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
<body>
    @include('layout.navbar2')

    <style>
        .content-wrapper {
            background-color: #eef4ff;
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

    <div class="content-wrapper">
        <div class="bg-white p-5 pt-4 pb-4 rounded m-5 mt-4 mb-4">
            <form action="{{ route('dokter.submit') }}" method="POST">
            @csrf
            <h3 class="mb-0 fw-bold text-center" style="color: #012970; font-family: 'Open Sans', sans-serif;">Draft</h3>
            <div class="">
                <div class="form-group d-flex flex-column mt-3">
                    <label>Judul Draft</label>
                    <input type="text" name="judul" class="form-control form-control-lg" placeholder="Judul Draft">
                </div>

                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>Deskripsi Draft</label>
                    <textarea name="deskripsi" class="form-control" rows="10" placeholder="Deskripsi"></textarea>
                </div>

                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary fw-bold m-3" style="font-family:'Inter', sans-serif; border-radius: 50px; width: 200px; background-color: #1A76D1">Simpan</button>
                    <a href="{{ route('dokter.listdaftar') }}" class="btn btn-primary fw-bold m-3" style="font-family:'Inter', sans-serif; border-radius: 50px; width: 200px; background-color: #ffff; color: #1A76D1; border-color: #1A76D1">Kembali</a>
                </div>
            </div>

        </form>
        </div>
    </div>
</body>
</html>

Pemeriksaan MRI Otak dilakukan untuk menilai struktur otak secara detail menggunakan medan magnet dan gelombang radio. Pemeriksaan ini tidak melibatkan radiasi ionisasi. Protokol standar mencakup sekuens T1-weighted, T2-weighted, FLAIR, DWI/ADC, serta T1 post-contrast apabila diberikan media kontras gadolinium.

