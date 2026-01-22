@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900 py-12">
    <div class="w-full sm:max-w-lg px-8 py-10 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Name') }}</label>
                <input id="name" type="text" class="block mt-1 w-full py-2.5 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Email') }}</label>
                <input id="email" type="email" class="block mt-1 w-full py-2.5 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="empresa_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Empresa') }}</label>
                <select id="empresa_id" name="empresa_id" required class="block mt-1 w-full py-2.5 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">{{ __('Selecciona una empresa') }}</option>
                    @foreach ($empresas ?? [] as $empresa)
                        <option value="{{ $empresa->id }}" {{ old('empresa_id') == $empresa->id ? 'selected' : '' }}>
                            {{ $empresa->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('empresa_id')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="fecha_fin" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Fecha fin') }}</label>
                <input id="fecha_fin" type="date" class="block mt-1 w-full py-2.5 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                @error('fecha_fin')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Password') }}</label>
                <input id="password" type="password" class="block mt-1 w-full py-2.5 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" name="password" required autocomplete="new-password">
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <label for="password-confirm" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="block mt-1 w-full py-3 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="flex items-center justify-between mt-10">
                @if (Route::has('login'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>
                @endif

                <button type="submit" class="inline-flex items-center px-8 py-4 bg-indigo-600 border border-transparent rounded-md font-semibold text-l text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
