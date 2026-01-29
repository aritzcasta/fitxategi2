@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 py-12 px-4">
    <div class="w-full sm:max-w-md">
        <!-- Tarjeta principal -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-white mb-1">Recuperar Contraseña</h2>
                    <p class="text-slate-300 text-sm">Introduce tu correo y te enviaremos un enlace para restablecer tu contraseña</p>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                @if (session('status'))
                    <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('status') }}
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Correo Electrónico
                        </label>
                        <input
                            id="email"
                            type="email"
                            class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="ejemplo@correo.com"
                            required
                            autocomplete="email"
                            autofocus
                        />

                        @error('email')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full group relative overflow-hidden flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-base transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 hover:from-slate-800 hover:via-slate-900 hover:to-black mb-4">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000"></div>
                        <span class="relative z-10">Enviar Enlace de Recuperación</span>
                    </button>

                    <div class="text-center">
                        <a class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium text-sm transition" 
                           href="{{ route('login') }}">
                            Volver al inicio de sesión
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
