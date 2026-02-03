@extends('layouts.admin')

@section('content')
<div class="max-w-md mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-orange-600 to-orange-700 px-8 py-6">
            <div class="flex items-center justify-center gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-white mb-1">Confirmar Contraseña</h2>
                    <p class="text-orange-100 text-sm">Área de seguridad - Verificación requerida</p>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="p-8">
            <div class="bg-orange-50 dark:bg-orange-900/20 rounded-2xl p-6 border-2 border-orange-200 dark:border-orange-800 mb-6">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-orange-700 dark:text-orange-300">
                        <p class="font-semibold">Por favor, confirma tu contraseña para continuar.</p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border bg-orange-50 text-orange-800 border-orange-200 dark:bg-orange-900/30 dark:text-orange-200 dark:border-orange-800">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.borrar-empresas.verify') }}">
                @csrf
                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Tu Contraseña
                    </label>
                    <input type="password" 
                           id="password" 
                           name="password" 
                           required 
                           autofocus
                           class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-orange-600 dark:focus:border-orange-500 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-orange-200 dark:focus:ring-orange-700 transition"
                           placeholder="••••••••">
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.panel') }}"
                       class="flex-1 px-6 py-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 text-center border-2 border-gray-200 dark:border-gray-600">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Verificar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
