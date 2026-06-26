<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    {{-- Bootstrap 5 css cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('styles')
    <style>
        main {
            min-height: 75vh;
        }
    </style>
</head>
<body>
    @if(!isset($no_navbar) || !$no_navbar)
        @include('templates.navbar')
    @endif
    <main>
    @yield('content')
    </main>

    {{-- Bootstrap 5 js cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    @if(!isset($no_navbar) || !$no_navbar)
        @include('templates.footer')
    @endif
</body>
</html>