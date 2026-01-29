<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Tailwind (CDN) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Hacer el icono del selector de fecha más visible en fondos oscuros (WebKit) */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(2);
        }
        /* Opcional: mejorar visibilidad del indicador en otros navegadores si aplicable */
        input[type="date"]::-ms-clear,
        input[type="date"]::-ms-expand {
            filter: invert(1) brightness(2);
        }
    </style>

    <!-- Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body class="m-0">
    <div id="app">
        <main>
            @yield('content')
        </main>

        @yield('mobile-nav')
    </div>
</body>
</html>
