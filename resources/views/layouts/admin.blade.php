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
<body class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 text-gray-800 dark:text-gray-100">
    <div class="flex">
        {{-- Sidebar --}}
        <aside class="hidden md:flex md:flex-col w-72 bg-white dark:bg-gray-800 border-r-2 border-gray-200 dark:border-gray-700 min-h-screen shadow-xl">
            <div class="p-6 bg-gradient-to-r from-slate-700 to-slate-800">
                <a href="{{ route('admin.panel') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-white">Fitxategi</span>
                        <p class="text-xs text-slate-300">Panel Admin</p>
                    </div>
                </a>
            </div>

            <nav class="p-4 flex-1">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.empresas') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.empresas') ? 'bg-slate-700 text-white shadow-lg border-2 border-slate-500' : 'text-gray-700 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800 border-2 border-transparent' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                <span>Empresas</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.usuarios') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.usuarios') ? 'bg-slate-700 text-white shadow-lg border-2 border-indigo-700' : 'text-gray-700 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <span>Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.justificaciones') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.justificaciones') ? 'bg-slate-700 text-white shadow-lg border-2 border-orange-700 ' : 'text-gray-700 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <span>Justificaciones</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.festivos') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.festivos') ? 'bg-slate-700 text-white shadow-lg border-2 border-red-700' : 'text-gray-700 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span>Festivos</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.borrar-usuarios') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 {{ request()->routeIs('admin.borrar-usuarios*') ? 'bg-slate-700 text-white shadow-lg border-2 border-red-700' : 'text-gray-700 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            <span>Borrar Usuarios</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition-all duration-200 text-gray-700 dark:text-gray-200 hover:bg-slate-100 dark:hover:bg-slate-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Volver al inicio</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-4 border-t-2 border-gray-200 dark:border-gray-700">
                @auth
                    <div class="text-xs text-slate-600 dark:text-slate-400 mb-2 font-medium">Conectado como</div>
                    <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800 rounded-xl">
                        <div class="w-10 h-10 bg-gradient-to-br from-slate-600 to-slate-800 text-white rounded-xl flex items-center justify-center font-bold shadow-lg">{{ strtoupper(substr(auth()->user()->nombre,0,1)) }}</div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100 truncate">{{ auth()->user()->nombre }}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</div>
                        </div>
                    </div>
                @endauth
            </div>
        </aside>

        <div class="flex-1 min-h-screen">
            {{-- Header --}}
            <header class="w-full bg-white dark:bg-gray-800 border-b-2 border-gray-200 dark:border-gray-700 shadow-lg">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center h-16">
                        <div class="flex items-center gap-4">
                            <button class="md:hidden p-2 rounded-xl text-gray-600 dark:text-gray-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                        </div>

                        <div class="flex items-center gap-3">
                            @auth
                                <span class="hidden sm:inline text-sm font-medium text-gray-700 dark:text-gray-300">{{ auth()->user()->nombre }}</span>
                                <form method="POST" action="{{ route('logout') }}">@csrf
                                    <button class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 transition-all duration-200 shadow-md hover:shadow-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        <span class="hidden sm:inline">Salir</span>
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
                {{-- Mobile menu --}}
                <div id="mobile-menu" class="md:hidden hidden px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-slate-50 dark:bg-slate-900">
                    <nav class="space-y-1">
                        <a href="{{ route('admin.empresas') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            Empresas
                        </a>
                        <a href="{{ route('admin.usuarios') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Usuarios
                        </a>
                        <a href="{{ route('admin.justificaciones') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Justificaciones
                        </a>
                        <a href="{{ route('admin.festivos') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Festivos
                        </a>
                        <a href="{{ route('admin.borrar-usuarios') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Borrar Usuarios
                        </a>
                        <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-slate-200 dark:hover:bg-slate-800 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            Volver al inicio
                        </a>
                    </nav>
                </div>
            </header>

            {{-- Content container --}}
            <main class="py-8 px-4">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-3xl border border-gray-100 dark:border-gray-700 p-8">
                        @yield('content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
