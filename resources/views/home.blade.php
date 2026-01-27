@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 relative">
    <form method="POST" action="{{ route('logout') }}" class="hidden sm:inline-flex absolute top-4 right-4">
        @csrf
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-400 dark:bg-gray-800 dark:text-gray-100 dark:hover:bg-gray-700 shadow-sm">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                <polyline points="16 17 21 12 16 7" />
                <line x1="21" y1="12" x2="9" y2="12" />
            </svg>
            {{ __('Logout') }}
        </button>
    </form>
    
    @if (auth()->user() && auth()->user()->rol && auth()->user()->rol->nombre === 'admin')
        <a href="{{ route('admin.panel') }}" class="hidden sm:inline-flex absolute top-16 right-4 items-center gap-2 px-3 py-2 rounded-md text-sm font-medium bg-red-600 text-white hover:bg-red-500 transition shadow">Panel Admin</a>
    @endif
    <div class="w-full max-w-lg px-6 py-10 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden rounded-3xl text-center">
        @if (auth()->user() && auth()->user()->rol && auth()->user()->rol->nombre === 'admin')
            <div class="absolute top-4 left-4">
                <a href="{{ route('codigo') }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 hover:bg-indigo-200 transition dark:bg-indigo-900 dark:text-indigo-200">
                    <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    Ver código
                </a>
            </div>
        @endif

        <!-- Bienvenida -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-1">
                ¡Bienvenido, {{ auth()->user()->nombre }}!
            </h1>
            
        </div>

        @if (session('status'))
            <div class="mb-4 px-4 py-3 rounded-lg text-sm {{ session('error') ? 'bg-red-100 text-red-700 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-200' }}">
                {{ session('status') }}
            </div>
        @endif

        <!-- Estado -->
        <div class="mb-8">
            
            
            <div id="mensaje-estado" class="px-6 py-2.5 rounded-full text-sm font-medium inline-block" style="background-color: #fce7f3; color: #be185d;">
                @if ($yaEntrada && !$yaSalida)
                    Sesión en curso
                @else
                    Sin registros hoy
                @endif
            </div>
        </div>

        <!-- Botones de control -->
        <div id="controles-cronometro" class="space-y-3">
            @if (!$yaEntrada || $yaSalida)
                <!-- Botón Iniciar -->
                <button onclick="mostrarModalCodigo('iniciar')" 
                        type="button"
                        class="w-full flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7z"/>
                    </svg>
                    Iniciar
                </button>
            @else
                <!-- Botón Pausa (visible solo cuando está iniciado, pero no hace nada) -->
                <button id="btn-pausa" 
                        type="button"
                        class="w-full flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="6" y="4" width="4" height="16"></rect>
                        <rect x="14" y="4" width="4" height="16"></rect>
                    </svg>
                    Pausa
                </button>

                <!-- Botón Finalizar -->
                <button onclick="mostrarModalCodigo('finalizar')" 
                        type="button"
                        class="w-full flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-semibold text-lg transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                        <rect x="6" y="6" width="12" height="12"></rect>
                    </svg>
                    Finalizar
                </button>

                @if (!$puedeSalida)
                    <div class="text-xs text-center text-gray-500 dark:text-gray-400 mt-2">
                        Puedes finalizar a partir de {{ $horaFin ? $horaFin->format('H:i') : 'tu horario' }}
                    </div>
                @endif
            @endif
        </div>
        
        <!-- Botón Justificar falta -->
        <div class="mt-4">
            <button onclick="mostrarModalJustificar()" type="button" class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-xl text-white font-semibold bg-gray-600 hover:bg-gray-700 transition shadow">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 10v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-6"/><path d="M7 10V7a5 5 0 0 1 10 0v3"/></svg>
                Justificar falta
            </button>
        </div>
    </div>

    <!-- Modal para ingresar código -->
    <div id="modal-codigo" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md transform transition-all">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Ingresa el código</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">El código es válido por 15 segundos</p>
            
            <form id="form-codigo" method="POST" action="">
                @csrf
                <input type="text" 
                       name="codigo" 
                       id="input-codigo" 
                       class="w-full px-4 py-4 text-center text-2xl font-bold rounded-xl border-2 border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-200 dark:focus:ring-indigo-900 transition mb-6"
                       placeholder="000000"
                       maxlength="6"
                       required
                       autofocus>
                
                <div class="flex gap-3">
                    <button type="button" 
                            onclick="cerrarModalCodigo()"
                            class="flex-1 px-6 py-3 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition shadow-lg">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para justificar falta -->
    <div id="modal-justificar" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 w-full max-w-md transform transition-all">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Justificar falta</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Describe la ausencia y, si quieres, adjunta una foto.</p>

            <form id="form-justificar" method="POST" action="{{ route('fichaje.justificar') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Fecha (opcional)</label>
                    <input type="date" name="fecha" class="w-full rounded-md border border-gray-200 px-3 py-2 bg-white text-gray-900">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Descripción</label>
                    <textarea name="descripcion" required class="w-full rounded-md border border-gray-200 px-3 py-2 bg-white text-gray-900" rows="4" placeholder="Explica por qué no pudiste fichar..."></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Adjuntar foto (opcional)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full text-sm text-gray-600">
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="cerrarModalJustificar()" class="flex-1 px-6 py-3 rounded-xl font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition">Cancelar</button>
                    <button type="submit" class="flex-1 px-6 py-3 rounded-xl font-semibold text-white bg-indigo-600 hover:bg-indigo-700 transition">Enviar justificación</button>
                </div>
            </form>
        </div>
    </div>

    <nav class="fixed bottom-0 left-0 right-0 sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 shadow-lg">
        <div class="flex items-center justify-around py-3">
            <a href="{{ route('perfil') }}" class="flex flex-col items-center text-xs text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <span class="mt-1">Mi perfil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex flex-col items-center text-xs text-gray-600 dark:text-gray-300 hover:text-red-600 dark:hover:text-red-400 transition">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span class="mt-1">Logout</span>
                </button>
            </form>
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
