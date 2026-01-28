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
                            Calculado con 8h/día hasta {{ $usuario->fecha_fin ? $usuario->fecha_fin->format('d/m/Y') : 'sin fecha' }}
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
            </div>
        </div>
    </div>
</div>
@endsection
