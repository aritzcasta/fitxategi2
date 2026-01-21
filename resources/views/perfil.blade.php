@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-start justify-center px-4 py-8">
    <div class="w-full max-w-2xl bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Mi perfil</h1>
            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $usuario->nombre }}</span>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Horas restantes (estimadas)</p>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $horasRestantes !== null ? $horasRestantes : '—' }}
                </p>
                <p class="mt-1 text-xs text-gray-400">Calculado con 8h/día hasta {{ $usuario->fecha_fin ? $usuario->fecha_fin->format('d/m/Y') : 'sin fecha' }}.</p>
            </div>

            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Incidencias</p>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $incidencias }}</p>
            </div>

            <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Llegadas tarde</p>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $llegadasTarde }}</p>
            </div>
        </div>

        <div class="mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-500 transition">Volver</a>
        </div>
    </div>
</div>
@endsection
