<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Mediplus')</title>
  <link rel="stylesheet" href="{{ asset('bootstrap5/css/bootstrap.min.css') }}">
  {{-- Ini aku nambah folder css buat custom css -> mobile UI --}}
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> 
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  @vite(['resources/js/inline-edit.js'])
  @stack('page-scripts')

</head>
<body class="bg-white text-dark">

  @include('layout.navbar')

  <main>
    @yield('content')
  </main>

  @include('layout.footer')

  <script src="{{ asset('bootstrap5/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
