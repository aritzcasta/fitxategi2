@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Tarjeta Principal -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-1">Mi Perfil</h1>
                            <p class="text-slate-300 text-sm">{{ $usuario->nombre }}</p>
                        </div>
                    </div>
                    <a href="{{ route('home') }}"
                       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 bg-white hover:bg-slate-50 transition-all duration-200 shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver
                    </a>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Horas Restantes -->
                    <div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 rounded-2xl border-2 border-slate-200 dark:border-slate-700 p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400">Horas Restantes</p>
                        </div>
                        <p class="text-4xl font-bold text-slate-900 dark:text-slate-100 mb-2">
                            {{ $horasRestantes !== null ? $horasRestantes : '—' }}
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Calculado con 7h/día hasta {{ $usuario->fecha_fin ? $usuario->fecha_fin->format('d/m/Y') : 'sin fecha' }}
                        </p>
                    </div>

                    <!-- Incidencias -->
                    <div class="bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border-2 border-amber-200 dark:border-amber-800 p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-amber-700 dark:text-amber-400">Incidencias</p>
                        </div>
                        <p class="text-4xl font-bold text-amber-900 dark:text-amber-100">{{ $incidencias }}</p>
                    </div>

                    <!-- Llegadas Tarde -->
                    <div class="bg-gradient-to-br from-red-50 to-rose-100 dark:from-red-900/20 dark:to-rose-900/20 rounded-2xl border-2 border-red-200 dark:border-red-800 p-6 shadow-lg hover:shadow-xl transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-red-600 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-sm font-semibold text-red-700 dark:text-red-400">Llegadas Tarde</p>
                        </div>
                        <p class="text-4xl font-bold text-red-900 dark:text-red-100">{{ $llegadasTarde }}</p>
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="mt-8 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border-2 border-blue-200 dark:border-blue-800 p-6 shadow-lg">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-blue-900 dark:text-blue-100">Cambiar Contraseña</h2>
                    </div>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('perfil.updatePassword') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="current_password" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">
                                Contraseña Actual
                            </label>
                            <input type="password" id="current_password" name="current_password" required
                                   class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-blue-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">
                                Nueva Contraseña
                            </label>
                            <input type="password" id="password" name="password" required minlength="8"
                                   class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-blue-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-blue-700 dark:text-blue-300 mb-2">
                                Confirmar Nueva Contraseña
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full px-4 py-3 rounded-xl border-2 border-blue-200 dark:border-blue-700 bg-white dark:bg-gray-800 text-blue-900 dark:text-blue-100 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl">
                            Actualizar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('mobile-nav')
<!-- Navegación móvil -->
<nav class="fixed bottom-0 left-0 right-0 sm:hidden bg-white dark:bg-gray-800 border-t-2 border-gray-200 dark:border-gray-700 shadow-2xl backdrop-blur-lg z-40">
    <div class="flex items-center justify-around py-2">
        <a href="{{ route('home') }}" class="flex flex-col items-center py-2 px-4 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
            <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-1 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                </svg>
            </div>
            <span>Inicio</span>
        </a>

        @if (auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
            <a href="{{ route('codigo') }}" class="flex flex-col items-center py-2 px-4 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-1 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                </div>
                <span>Código</span>
            </a>
        @endif

        <a href="{{ route('perfil') }}" class="flex flex-col items-center py-2 px-4 text-xs font-semibold text-slate-700 dark:text-slate-300 relative">
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-1 transition-colors border-4 border-blue-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span>Perfil</span>
            <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-slate-700 dark:bg-slate-300 rounded-t-full"></div>
        </a>

        @if (auth()->user() && auth()->user()->rol && auth()->user()->rol->nombre === 'admin')
            <a href="{{ route('admin.panel') }}" class="flex flex-col items-center py-2 px-4 text-xs font-medium text-gray-600 dark:text-gray-400 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-1 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                </div>
                <span>Admin</span>
            </a>
        @endif
    </div>
</nav>
@endsection
