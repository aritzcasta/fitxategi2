@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 dark:bg-gray-900">
    <div class="w-full sm:max-w-md px-8 py-10 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('Reset Password') }}</h1>
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">{{ __('Please enter your new password below.') }}</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">{{ __('Email Address') }}</label>
                <input id="email" type="email" class="block mt-1 w-full py-3 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('email') border-red-600 @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus />
                @error('email')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">{{ __('Password') }}</label>
                <input id="password" type="password" class="block mt-1 w-full py-3 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 @error('password') border-red-600 @enderror" name="password" required autocomplete="new-password" />
                @error('password')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password-confirm" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="block mt-1 w-full py-3 px-4 rounded-md shadow-sm border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-between">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100" href="{{ route('login') }}">{{ __('Back to login') }}</a>

                <button type="submit" class="inline-flex items-center px-7 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 transition ease-in-out duration-150">{{ __('Reset Password') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
