@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="w-full sm:max-w-md px-6 py-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg text-center">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ __('Bienvenido') }}</h1>

        @if (session('status'))
            <div class="mt-4 text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <p class="mt-4 text-gray-600 dark:text-gray-300">
            {{ __('Has iniciado sesión correctamente.') }}
        </p>

        <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
            @if ($yaEntrada)
                Entrada registrada hoy.
            @else
                Aún no has registrado la entrada de hoy.
            @endif
        </div>

        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
            @if ($yaSalida)
                Salida registrada hoy.
            @elseif (! $yaEntrada)
                Registra primero la entrada.
            @elseif (! $puedeSalida)
                Puedes registrar la salida a partir de {{ $horaFin ? $horaFin->format('H:i') : 'tu horario' }}.
            @else
                Ya puedes registrar la salida.
            @endif
        </div>

        <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center">
            @php
                $esSalida = $yaEntrada && ! $yaSalida;
                $disabledPrincipal = $yaEntrada && ($yaSalida || ! $puedeSalida);
            @endphp
            <form method="POST" action="{{ $esSalida ? route('fichaje.salida') : route('fichaje.entrada') }}" class="w-full">
                @csrf
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Código de inicio (15s)</label>
                    <input id="codigo" name="codigo" type="text" required class="mt-2 w-full rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="123456">
                </div>
                <div class="mt-3 flex flex-col sm:flex-row gap-2 justify-center">
                    <button type="submit" class="inline-flex items-center px-6 py-3 rounded-md font-semibold text-sm uppercase tracking-widest transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 {{ $disabledPrincipal ? 'bg-gray-300 text-gray-600 cursor-not-allowed' : ($esSalida ? 'bg-emerald-600 text-white hover:bg-emerald-500 focus:ring-emerald-500' : 'bg-indigo-600 text-white hover:bg-indigo-500 focus:ring-indigo-500') }}" {{ $disabledPrincipal ? 'disabled' : '' }}>
                        {{ $esSalida ? __('Desfichar') : __('Empezar') }}
                </button>
                    @if (auth()->user() && auth()->user()->rol && auth()->user()->rol->nombre === 'admin')
                        <a href="{{ route('codigo') }}" class="inline-flex items-center px-6 py-3 rounded-md font-semibold text-sm uppercase tracking-widest transition ease-in-out duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 bg-transparent text-gray-800 hover:bg-gray-200 hover:text-gray-800 focus:ring-indigo-500 dark:bg-transparent dark:text-gray-100 dark:hover:bg-gray-700 dark:hover:text-gray-100">
                            {{ __('Ver código') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <nav class="fixed bottom-0 left-0 right-0 sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-around py-2">
            <a href="{{ route('perfil') }}" class="flex flex-col items-center text-xs text-gray-600 dark:text-gray-300">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
                <span>Mi perfil</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex flex-col items-center text-xs text-gray-600 dark:text-gray-300">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>
</div>
@endsection
