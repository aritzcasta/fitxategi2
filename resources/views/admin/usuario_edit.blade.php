@extends('layouts.admin')

@section('content')
    <div class="max-w-2xl mx-auto">
        <div class="bg-indigo-100 dark:bg-gray-900 shadow-lg rounded-lg p-6 ring-1 ring-indigo-100 dark:ring-gray-700">
            <h2 class="text-xl font-semibold mb-4">Editar usuario</h2>

            @if(session('status'))
                <div class="mb-4 text-sm text-green-600">{{ session('status') }}</div>
            @endif

            <div class="bg-gray-50 dark:bg-gray-800 p-6 rounded-md shadow-md">
                <form method="POST" action="{{ route('admin.usuarios.update', $user->id) }}">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Nombre</label>
                    <div class="text-gray-700 dark:text-gray-200">{{ $user->nombre }}</div>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium mb-1">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full rounded-md border border-gray-200 px-3 py-2 bg-white text-gray-900" required>
                    @error('email') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium mb-1">Contraseña (dejar en blanco para no cambiar)</label>
                    <input id="password" name="password" type="password" class="w-full rounded-md border border-gray-200 px-3 py-2 bg-white text-gray-900">
                    @error('password') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full rounded-md border border-gray-200 px-3 py-2 bg-white text-gray-900">
                </div>

                <div class="mb-4">
                    <label for="fecha_fin" class="block text-sm font-medium mb-1">Fecha fin de prácticas</label>
                    <input id="fecha_fin" name="fecha_fin" type="date" value="{{ old('fecha_fin', optional($user->fecha_fin)->format('Y-m-d')) }}" class="w-full rounded-md border border-gray-200 px-3 py-2 bg-white text-gray-900">
                    @error('fecha_fin') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md">Guardar</button>
                    <a href="{{ route('admin.usuarios') }}" class="text-sm text-gray-600 dark:text-gray-300">Cancelar</a>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
