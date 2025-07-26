<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>
        @yield('title', 'Mediplus')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="{{ asset('images/Mediplus.png') }}" type="image/png">

    <link href="{{ asset('bootstrap5/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body class="overflow-hidden">
    @yield('navbar')

    <main class="py-4">
        @yield('content')
    </main>

    @yield('footer')

    <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
