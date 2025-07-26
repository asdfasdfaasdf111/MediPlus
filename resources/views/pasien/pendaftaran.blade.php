<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
    <title>Pendaftaran</title>
</head>
<body>
    @include('layout.navbar2')
    <a href="{{ route('pasien.pendaftaran') }}">
        <button type="button"> Book Appointment</button>
    </a>

    <script src="{{ asset('bootstrap/js/bootstrap5.bundle.min.js') }}"></script>
</body>
</html>