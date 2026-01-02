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

    <div class="content-wrapper bg-light">
        <div class="bg-white p-5 pt-4 pb-4 rounded m-5 mt-2 mb-1">
            <form action="{{ route('superadmin.submitdata', $rumahSakit->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <h3 class="mb-0 fw-bold" style="color: #012970;">Data Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Nama Rumah Sakit</label>
                    <input type="text" name="nama_rs" class="form-control form-control-lg @error('nama_rs') is-invalid @enderror" value="{{ old('nama_rs', $rumahSakit->nama) }}">
                    @error('nama_rs') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3">
                    <label>Alamat Rumah Sakit</label>
                    <input type="text" name="alamat" class="form-control form-control-lg @error('alamat') is-invalid @enderror" value="{{ old('alamat', $rumahSakit->alamat) }}">
                    @error('alamat') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3">
                    <label>No. Telepon Rumah Sakit</label>
                    <input type="text" name="noTelepon" class="form-control form-control-lg @error('noTelepon') is-invalid @enderror" value="{{ old('noTelepon', $rumahSakit->noTelepon) }}">
                    @error('noTelepon') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3">
                    <label>Foto Profil Rumah Sakit (opsional)</label>
                    <input type="file"
                        class="form-control form-control-lg @error('foto') is-invalid @enderror" name="foto" accept="image/*">
                    @error('foto')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <h3 class="mb-0 fw-bold mt-4" style="color: #012970;">Data Admin Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-2">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_admin" class="form-control form-control-lg @error('nama_admin') is-invalid @enderror" value="{{ old('nama_admin', $rumahSakit->admin->user->name) }}">
                    @error('nama_admin') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3" >
                    <label>Email</label>
                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" value="{{ old('email', $rumahSakit->admin->user->email) }}">
                    @error('email') 
                        <div class="invalid-feedback">{{ $message }}</div> 
                    @enderror
                </div>

                <div class="form-group d-flex flex-column mt-3">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg @error('password') is-invalid @enderror" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>

                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Konfirmasi Password">
                        
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
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
