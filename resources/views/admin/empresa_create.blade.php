@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Crear empresa</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Da de alta una nueva empresa en el sistema</p>
                </div>
                <a href="{{ route('admin.empresas') }}" class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                    Volver
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow border bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <h2 class="text-xl font-bold text-white">Datos de la empresa</h2>
                <p class="text-slate-300 text-sm">Completa el nombre para crearla</p>
            </div>

            <form method="POST" action="{{ route('admin.empresas.store') }}" class="p-8">
                @csrf

                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Nombre <span class="text-red-500">*</span></label>
                    <input
                        id="nombre"
                        name="nombre"
                        type="text"
                        value="{{ old('nombre') }}"
                        required
                        class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('nombre') ? 'border-red-300 dark:border-red-700' : 'border-gray-200 dark:border-gray-600' }} bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition"
                        placeholder="Nombre de la empresa"
                    >
                    @error('nombre')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 mt-8">
                    <a href="{{ route('admin.empresas') }}" class="flex-1 text-center px-6 py-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 border-2 border-gray-200 dark:border-gray-600">
                        Cancelar
                    </a>
                    <button type="submit" class="flex-1 px-6 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Crear
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
