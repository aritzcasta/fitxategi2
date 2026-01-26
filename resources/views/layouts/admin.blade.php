<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 min-h-screen">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <a href="{{ route('admin.panel') }}" class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ config('app.name') }}<span class="text-sm text-gray-500"> · Admin</span></a>
            </div>

            <nav class="p-4">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.panel') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.usuarios') }}" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="mt-auto p-4 border-t border-gray-100 dark:border-gray-700">
                @auth
                    <div class="text-xs text-gray-500 dark:text-gray-400 mb-2">Conectado como</div>
                    <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ auth()->user()->nombre }}</div>
                @endauth
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 p-6">
            @yield('content')
        </div>
    </div>
</body>
</html>
