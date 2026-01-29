@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 relative py-8 px-4">

    <!-- Barra superior -->
    <div class="max-w-5xl mx-auto mb-8">
        <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-2xl shadow-lg px-6 py-4 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center shadow-lg">
                    <span class="text-white font-bold text-xl">{{ substr(auth()->user()->nombre, 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 dark:text-white">{{ auth()->user()->nombre }}</h1>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ now()->locale('es')->isoFormat('dddd, D MMMM YYYY') }}</p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                @if (auth()->check() && method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin())
                    <a href="{{ route('codigo') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-slate-700 text-white hover:bg-slate-800 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                        <span class="hidden md:inline">Ver Código</span>
                    </a>
                @endif

                @if (auth()->user() && auth()->user()->rol && auth()->user()->rol->nombre === 'admin')
                    <a href="{{ route('admin.panel') }}" class="hidden sm:inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-slate-800 text-white hover:bg-slate-900 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="3" width="7" height="7"></rect>
                            <rect x="14" y="3" width="7" height="7"></rect>
                            <rect x="14" y="14" width="7" height="7"></rect>
                            <rect x="3" y="14" width="7" height="7"></rect>
                        </svg>
                        <span class="hidden md:inline">Admin</span>
                    </a>
                @endif

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        <span class="hidden sm:inline">Salir</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="max-w-5xl mx-auto">
        @if (session('status'))
            <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border {{ session('error') ? 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-200 dark:border-red-800' : 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800' }}">
                <div class="flex items-center gap-3">
                    @if (session('error'))
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    @else
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    @endif
                    {{ session('status') }}
                </div>
            </div>
        @endif

        @if (!empty($esNoLaborable))
            <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-900/30 dark:text-amber-200 dark:border-amber-800">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.518 11.59c.75 1.334-.214 2.99-1.742 2.99H3.48c-1.528 0-2.492-1.656-1.742-2.99L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-8a1 1 0 00-1 1v4a1 1 0 102 0V7a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $motivoNoLaborable ?? 'Hoy no es un día laborable' }}. No debes fichar.</span>
                </div>
            </div>
        @endif

        @if (session('warning'))
            <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border bg-amber-50 text-amber-800 border-amber-200 dark:bg-amber-900/30 dark:text-amber-200 dark:border-amber-800">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.721-1.36 3.486 0l6.518 11.59c.75 1.334-.214 2.99-1.742 2.99H3.48c-1.528 0-2.492-1.656-1.742-2.99L8.257 3.1zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-8a1 1 0 00-1 1v4a1 1 0 102 0V7a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('warning') }}
                </div>
            </div>
        @endif

        <!-- Tarjeta Principal -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header de la tarjeta -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Fichaje</h2>
                        <p class="text-slate-300 text-sm">Gestiona tu jornada laboral</p>
                    </div>
                    <div class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl {{ $yaEntrada && !$yaSalida ? 'bg-emerald-500/20 border border-emerald-400/30' : 'bg-slate-600/30 border border-slate-500/30' }}">
                        <span class="w-2.5 h-2.5 rounded-full {{ $yaEntrada && !$yaSalida ? 'bg-emerald-400 animate-pulse' : 'bg-slate-400' }}"></span>
                        <span class="text-sm font-semibold {{ $yaEntrada && !$yaSalida ? 'text-emerald-200' : 'text-slate-300' }}">
                            @if ($yaEntrada && !$yaSalida)
                                En Jornada
                            @else
                                Fuera de Jornada
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <!-- Cuerpo de la tarjeta -->
            <div class="p-8">
                <!-- Estado Mobile -->
                <div class="sm:hidden mb-6 flex justify-center">
                    <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl {{ $yaEntrada && !$yaSalida ? 'bg-emerald-50 border border-emerald-200 dark:bg-emerald-900/20 dark:border-emerald-800' : 'bg-gray-100 border border-gray-200 dark:bg-gray-700 dark:border-gray-600' }}">
                        <span class="w-2.5 h-2.5 rounded-full {{ $yaEntrada && !$yaSalida ? 'bg-emerald-500 animate-pulse' : 'bg-gray-400' }}"></span>
                        <span class="text-sm font-semibold {{ $yaEntrada && !$yaSalida ? 'text-emerald-700 dark:text-emerald-300' : 'text-gray-600 dark:text-gray-300' }}">
                            @if ($yaEntrada && !$yaSalida)
                                En Jornada
                            @else
                                Fuera de Jornada
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Botones de Control -->
                <div class="space-y-3">
                    @if (!empty($esNoLaborable))
                        <button type="button" disabled
                                class="w-full flex items-center justify-center gap-3 px-8 py-5 rounded-2xl text-white font-bold text-lg shadow-lg bg-slate-400 cursor-not-allowed opacity-80">
                            <svg class="w-7 h-7" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M8 12h8" fill="white"/>
                            </svg>
                            <span>No disponible hoy</span>
                        </button>
                    @elseif (!$yaEntrada || $yaSalida)
                        <!-- Botón Iniciar -->
                        <button onclick="mostrarModalCodigo('iniciar')"
                                type="button"
                                class="w-full group relative overflow-hidden flex items-center justify-center gap-3 px-8 py-5 rounded-2xl text-white font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 hover:from-slate-800 hover:via-slate-900 hover:to-black">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000"></div>
                            <svg class="w-7 h-7 relative z-10" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="M10 8l6 4-6 4V8z" fill="white"/>
                            </svg>
                            <span class="relative z-10">Iniciar Jornada</span>
                        </button>
                    @else
                        <!-- Botón Finalizar -->
                        <button onclick="mostrarModalCodigo('finalizar')"
                                type="button"
                                class="w-full group relative overflow-hidden flex items-center justify-center gap-3 px-8 py-5 rounded-2xl text-white font-bold text-lg transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 hover:from-slate-800 hover:via-slate-900 hover:to-black">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000"></div>
                            <svg class="w-7 h-7 relative z-10" viewBox="0 0 24 24" fill="currentColor">
                                <circle cx="12" cy="12" r="10"/>
                                <rect x="7" y="7" width="10" height="10" rx="2" fill="white"/>
                            </svg>
                            <span class="relative z-10">Finalizar Jornada</span>
                        </button>

                        @if (!$puedeSalida)
                            <div class="flex items-center justify-center gap-2 text-xs text-amber-700 dark:text-amber-400 bg-amber-50 dark:bg-amber-900/20 py-3 px-4 rounded-xl border border-amber-200 dark:border-amber-800">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">Puedes finalizar a partir de {{ $horaFin ? $horaFin->format('H:i') : 'tu horario' }}</span>
                            </div>
                        @endif
                    @endif
                </div>

                <!-- Divisor -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-3 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-medium"></span>
                    </div>
                </div>

                <!-- Botón Justificar -->
                <button @if (!empty($esNoLaborable)) disabled @else onclick="mostrarModalJustificar()" @endif
                        type="button"
                        class="w-full flex items-center justify-center gap-3 px-6 py-4 rounded-xl font-semibold text-base transition-all duration-200 border-2 {{ !empty($esNoLaborable) ? 'text-gray-400 dark:text-gray-400 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600 cursor-not-allowed opacity-80' : 'text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 border-gray-200 dark:border-gray-600 hover:border-gray-300 dark:hover:border-gray-500' }}">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span>Justificar Ausencia</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para ingresar código -->
    <div id="modal-codigo" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 px-4 transition-opacity">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md transform transition-all border-2 border-gray-100 dark:border-gray-700">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6 rounded-t-3xl">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Código de Acceso</h2>
                        <p class="text-sm text-slate-300">Introduce el código para continuar</p>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del modal -->
            <form id="form-codigo" method="POST" action="" class="p-8">
                @csrf
                <div class="mb-6">
                    <div class="flex items-center gap-2 mb-3 px-4 py-2 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-800">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-sm font-medium text-amber-700 dark:text-amber-400">Código válido por 15 segundos</span>
                    </div>
                    <input type="text"
                           name="codigo"
                           id="input-codigo"
                           class="w-full px-6 py-5 text-center text-3xl font-bold rounded-2xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition tracking-[0.5em]"
                           placeholder="000000"
                           maxlength="6"
                           required
                           autofocus>
                </div>

                <div class="flex gap-3">
                    <button type="button"
                            onclick="cerrarModalCodigo()"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 border-2 border-gray-200 dark:border-gray-600">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para justificar falta -->
    <div id="modal-justificar" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 px-4 transition-opacity">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md transform transition-all border-2 border-gray-100 dark:border-gray-700 max-h-[90vh] overflow-y-auto">
            <!-- Header del modal -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6 rounded-t-3xl sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Justificar Ausencia</h2>
                        <p class="text-sm text-slate-300">Documenta tu falta o incidencia</p>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del modal -->
            <form id="form-justificar" method="POST" action="{{ route('fichaje.justificar') }}" enctype="multipart/form-data" class="p-8">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Fecha <span class="text-gray-400">(opcional)</span></label>
                        <input type="date"
                               name="fecha"
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Descripción <span class="text-red-500">*</span></label>
                        <textarea name="descripcion"
                                  required
                                  class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition resize-none"
                                  rows="4"
                                  placeholder="Explica detalladamente el motivo de tu ausencia..."></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Adjuntar Documento <span class="text-gray-400">(opcional)</span></label>
                        <div class="relative">
                            <input type="file"
                                   name="foto"
                                   accept="image/*"
                                   class="w-full text-sm text-gray-600 dark:text-gray-400 file:mr-4 file:py-3 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 dark:file:bg-slate-700 dark:file:text-slate-200 dark:hover:file:bg-slate-600 cursor-pointer transition-all">
                        </div>
                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Formatos permitidos: JPG, PNG, PDF (máx. 5MB)</p>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button type="button"
                            onclick="cerrarModalJustificar()"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 border-2 border-gray-200 dark:border-gray-600">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Enviar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Navegación móvil -->
    <nav class="fixed bottom-0 left-0 right-0 sm:hidden bg-white dark:bg-gray-800 border-t-2 border-gray-200 dark:border-gray-700 shadow-2xl backdrop-blur-lg z-40">
        <div class="flex items-center justify-around py-2">
            <a href="{{ route('home') }}" class="flex flex-col items-center py-2 px-4 text-xs font-semibold text-slate-700 dark:text-slate-300 relative ">
                <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-1 transition-colors border-4 border-indigo-500">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </div>
                <span>Inicio</span>
                <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 w-8 h-1 bg-slate-700 dark:bg-slate-300 rounded-t-full"></div>
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

            <a href="{{ route('perfil') }}" class="flex flex-col items-center py-2 px-4 text-xs font-medium transition-colors {{ request()->routeIs('perfil') ? 'text-slate-700 dark:text-slate-200' : 'text-gray-600 dark:text-gray-400 hover:text-slate-700' }}">
    <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-1 transition-colors border-2
        {{ request()->routeIs('perfil')
            ? 'bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-lg border-indigo-700'
            : 'bg-gray-100 dark:bg-gray-700 border-transparent hover:bg-slate-200 dark:hover:bg-slate-600' }}">

        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
        </svg>
    </div>
    <span>Perfil</span>
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
</div>

<script>
    function mostrarModalCodigo(accion) {
        const modal = document.getElementById('modal-codigo');
        const form = document.getElementById('form-codigo');

        if (accion === 'iniciar') {
            form.action = '{{ route("fichaje.entrada") }}';
        } else if (accion === 'finalizar') {
            form.action = '{{ route("fichaje.salida") }}';
        }

        modal.classList.remove('hidden');
        document.getElementById('input-codigo').focus();
    }

    function cerrarModalCodigo() {
        document.getElementById('modal-codigo').classList.add('hidden');
        document.getElementById('input-codigo').value = '';
    }

    // Cerrar modal con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalCodigo();
        }
    });

    // Cerrar modal al hacer clic fuera
    document.getElementById('modal-codigo').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalCodigo();
        }
    });

    function mostrarModalJustificar() {
        document.getElementById('modal-justificar').classList.remove('hidden');
    }

    function cerrarModalJustificar() {
        document.getElementById('modal-justificar').classList.add('hidden');
        const form = document.getElementById('form-justificar');
        form.reset();
    }

    // Cerrar modal justificar con Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            cerrarModalJustificar();
        }
    });

    // Cerrar modal justificar al hacer clic fuera
    document.getElementById('modal-justificar').addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalJustificar();
        }
    });
</script>
@endsection
