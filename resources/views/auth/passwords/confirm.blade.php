@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 py-12 px-4">
    <div class="w-full sm:max-w-md">
        <!-- Tarjeta principal -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-white mb-1">{{ __('Confirm Password') }}</h2>
                    <p class="text-slate-300 text-sm">{{ __('Please confirm your password before continuing.') }}</p>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ __('Password') }}</label>
                        <input id="password" 
                               type="password" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition @error('password') border-red-600 @enderror" 
                               name="password" 
                               required 
                               autocomplete="current-password">

                        @error('password')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                            class="w-full group relative overflow-hidden flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-base transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 hover:from-slate-800 hover:via-slate-900 hover:to-black mb-4">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000"></div>
                        <span class="relative z-10">{{ __('Confirm Password') }}</span>
                    </button>

                    @if (Route::has('password.request'))
                        <div class="text-center">
                            <a class="text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium text-sm transition" 
                               href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
