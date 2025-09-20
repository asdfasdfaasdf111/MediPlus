<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Superadmin</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    @include('layout.navbar2')

    <style>
        .content-wrapper {
            background-color: #eef4ff;
            min-height: 100vh;
            justify-content: center;
            padding: 20px;
        }

        input.form-control {
            height: 40px;
            font-size: 15px;
            padding: 6px 10px;
        }
    </style>

     <div class="content-wrapper p-4">
        <div class="bg-white p-5 pt-4 pb-4 rounded m-5 mt-2 mb-1">
            <form action="{{ route('superadmin.submit') }}" method="POST">
                @csrf

                <h3 class="mb-0 fw-bold" style="color: #012970; font-family: 'Open Sans', sans-serif;">Data Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Nama Rumah Sakit</label>
                    <input type="text" class="form-control form-control-lg" name="nama_rs" placeholder="Nama Rumah Sakit">
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Alamat Rumah Sakit</label>
                    <input type="text" class="form-control form-control-lg" name="alamat" placeholder="Alamat Rumah Sakit">
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>No. Telepon Rumah Sakit</label>
                    <input type="text" class="form-control form-control-lg" name="noTelepon" placeholder="No. Telepon Rumah Sakit">
                </div>

                <h3 class="mb-0 fw-bold mt-4" style="color: #012970; font-family: 'Open Sans', sans-serif;">Data Admin Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control form-control-lg" name="nama_admin" placeholder="Nama Lengkap">
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Email</label>
                    <input type="text" class="form-control form-control-lg" name="email" placeholder="Email">
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Password</label>
                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Konfirmasi Password">
                </div>
                <div class="d-flex align-items-center justify-content-center">
                    <button type="submit" class="btn btn-primary fw-bold mt-3" style="font-family:'Inter', sans-serif; border-radius: 50px; width: 200px; background-color: #1A76D1">Simpan</button>
                    <a href="{{ route('superadmin.homepage') }}" class="mt-3 ps-4" style="color: grey">Kembali</a>
                </div>
            </form>
        </div>
     </div>
</body>
