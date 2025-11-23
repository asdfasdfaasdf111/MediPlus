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


    {{-- Buat yang alert, aku tambahin di controller dulu buat rulesnya, terus aku taroh error tiap field biar bukan global alert, melainkan per fieldnya
    sekalian aku nyimpen value old biar ga ilang kalo ada error validasi --}}
     <div class="content-wrapper p-4 bg-light">
        <div class="bg-white p-5 pt-4 pb-4 rounded m-5 mt-2 mb-1">

            <form action="{{ route('superadmin.submit') }}" method="POST">
                @csrf

                <h3 class="mb-0 fw-bold" style="color: #012970; font-family: 'Open Sans', sans-serif;">Data Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Nama Rumah Sakit</label>
                    <input type="text" class="form-control form-control-lg @error('nama_rs') is-invalid @enderror" name="nama_rs" placeholder="Nama Rumah Sakit" value="{{ old('nama_rs') }}">
                    @error('nama_rs')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Alamat Rumah Sakit</label>
                    <input type="text" class="form-control form-control-lg @error('alamat') is-invalid @enderror" name="alamat" placeholder="Alamat Rumah Sakit" value="{{ old('alamat') }}">
                    @error('alamat')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>No. Telepon Rumah Sakit</label>
                    <input type="text" class="form-control form-control-lg @error('noTelepon') is-invalid @enderror" name="noTelepon" placeholder="No. Telepon Rumah Sakit" value="{{ old('noTelepon') }}" >
                    @error('noTelepon')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <h3 class="mb-0 fw-bold mt-4" style="color: #012970; font-family: 'Open Sans', sans-serif;">Data Admin Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control form-control-lg @error('nama_admin') is-invalid @enderror" name="nama_admin" placeholder="Nama Lengkap" value="{{ old('nama_admin') }}" >
                    @error('nama_admin')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Email</label>
                    <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}" >
                    @error('email')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                 <div class="form-group d-flex flex-column mt-3">
                    <label>Password</label>
                    <input
                        type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" placeholder="Password" >
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3">
                    <label>Konfirmasi Password</label>
                    <input
                        type="password" class="form-control form-control-lg" name="password_confirmation" placeholder="Konfirmasi Password" >
                </div>

                <div class="d-flex justify-content-center gap-3 pt-3">
                    <a href="{{ route('superadmin.homepage') }}"
                    class="btn btn-outline-primary px-5 rounded-pill">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-primary px-5 rounded-pill">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
     </div>

     <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
