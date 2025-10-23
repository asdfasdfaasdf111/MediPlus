<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Homepage Dokter</title>
    <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
</head>
<body>
    @include('layout.navbar2')

        <div class="content-wrapper">
        <div class="" style="background-color: #eef4ff;">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="flex-grow-1 p-4">
                <form action="" class="form-inline my-2 my-lg-0" method="GET">
                    <div class="input-group">
                        <input class="form-control form-control-sm w-auto" type="text" name="search" placeholder="Telusuri" style="font-family: 'Open Sans', sans-serif;">
                        <button class="btn btn-outline-secondary" type="submit" style="background-color: #ffff">
                        <i class="bi bi-search" style="background-color: #ffff"></i>
                    </div>
                </form>
            </div>
            <div class="col-md-2 p-4">
                <form action="{{ route('superadmin.addnew') }}" method="GET">
                    <button type="submit" class="btn btn-primary w-100 fw-bold px-3">List Draft</button>
                </form>
            </div>
        </div>
</body>
</html>
