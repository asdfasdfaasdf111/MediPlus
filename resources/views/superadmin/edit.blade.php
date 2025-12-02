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

    <div class="content-wrapper bg-light">
        <div class="bg-white p-5 pt-4 pb-4 rounded m-5 mt-2 mb-1">
            <form action="{{ route('superadmin.submitdata', $rumahSakit->id) }}" method="POST">
                @csrf
                @method('PUT')

                <h3 class="mb-0 fw-bold" style="color: #012970; font-family: 'Open Sans', sans-serif;">Data Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-3">
                    <label>Nama Rumah Sakit</label>
                    <input type="text" name="nama_rs" class="form-control form-control-lg" value="{{ $rumahSakit->nama }}">
                </div>
                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>Alamat Rumah Sakit</label>
                    <input type="text" name="alamat" class="form-control form-control-lg" value="{{ $rumahSakit->alamat }}">
                </div>
                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>No. Telepon Rumah Sakit</label>
                    <input type="text" name="noTelepon" class="form-control form-control-lg" value="{{ $rumahSakit->noTelepon }}">
                </div>

                <h3 class="mb-0 fw-bold mt-4" style="color: #012970; font-family: 'Open Sans', sans-serif;">Data Admin Rumah Sakit</h3>
                <div class="form-group d-flex flex-column mt-2">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama_admin" class="form-control form-control-lg" value="{{ $rumahSakit->admin->user->name }}">
                </div>
                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" value="{{ $rumahSakit->admin->user->email }}">
                </div>
                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Kosongkan jika tidak ingin mengubah">
                </div>
                <div class="form-group d-flex flex-column mt-3" style="font-family:'Inter', sans-serif;">
                    <label>Konfirmasi Password</label>
                    <input type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password_confirmation" placeholder="Konfirmasi Password">
                        @if($errors->has('password'))
                            @foreach($errors->get('password') as $error)
                                <div class="invalid-feedback d-block">{{ $error }}</div>
                            @endforeach
                        @endif
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
