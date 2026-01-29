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
    <style>
        /* Hacer el icono del selector de fecha más visible en fondos oscuros (WebKit) */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(2);
        }
        input[type="date"]::-ms-clear,
        input[type="date"]::-ms-expand {
            filter: invert(1) brightness(2);
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="hidden md:flex md:flex-col w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 min-h-screen shadow-sm">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                <a href="{{ route('admin.panel') }}" class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold text-indigo-600">Fitxategi</span>
                    <span class="text-sm text-gray-500">Admin</span>
                </a>
            </div>

            <nav class="p-4 flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.empresas') }}" class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.empresas') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 transition-colors duration-150' : 'text-gray-700 dark:text-gray-200 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors duration-150' }}">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"></path></svg>
                            <span>Empresas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.usuarios') }}" class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.usuarios') ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30' : 'text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.761 0 5.292.86 7.121 2.304M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                            <span>Configuración</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-100 dark:border-gray-700">
                @auth
                    <div class="text-xs text-gray-500 dark:text-gray-400">Conectado como</div>
                    <div class="mt-1 flex items-center gap-3">
                        <div class="w-9 h-9 bg-indigo-500 text-white rounded-full flex items-center justify-center">{{ strtoupper(substr(auth()->user()->nombre,0,1)) }}</div>
                        <div>
                            <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ auth()->user()->nombre }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? '' }}</div>
                        </div>
                    </div>
                @endauth
            </div>
        </aside>

        <div class="flex-1 min-h-screen">
            {{-- Header --}}
            <header class="w-full bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center gap-4">
                            <button class="md:hidden p-2 rounded-md text-gray-600 dark:text-gray-300" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <form action="{{ url()->current() }}" method="GET" class="hidden sm:flex items-center bg-gray-100 dark:bg-gray-700 rounded-md px-3 py-1">
                                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar..." class="bg-transparent focus:outline-none text-sm" />
                            </form>
                        </div>

                        <div class="flex items-center gap-4">
                            <button class="p-2 rounded-md text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </button>

                            <div class="flex items-center gap-2">
                                @auth
                                    <span class="hidden sm:inline text-sm text-gray-600 dark:text-gray-300">{{ auth()->user()->nombre }}</span>
                                    <form method="POST" action="{{ route('logout') }}">@csrf
                                        <button class="ml-2 bg-indigo-600 text-white px-3 py-1 rounded-md text-sm">Salir</button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Mobile menu --}}
                <div id="mobile-menu" class="md:hidden hidden px-4 py-2">
                    <nav>
                        <a href="{{ route('admin.empresas') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200">Empresas</a>
                        <a href="{{ route('admin.usuarios') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 dark:text-gray-200">Usuarios</a>
                    </nav>
                </div>
            </header>

            {{-- Content container --}}
            <main class="py-8 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
