@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="w-full sm:max-w-md px-8 py-10 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
            {{ __('Reset Password') }}
        </h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            {{ __('Enter your email address and we will send you a link to reset your password.') }}
        </p>

        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900/30 px-4 py-3 text-sm text-green-700 dark:text-green-300">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-6">
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Email Address') }}
                </label>
                <input
                    id="email"
                    type="email"
                    class="block mt-1 w-full py-3 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    autofocus
                />

                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">
                    {{ __('Back to login') }}
                </a>

                <button type="submit" class="inline-flex items-center px-7 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 transition ease-in-out duration-150">
                    {{ __('Send Password Reset Link') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
