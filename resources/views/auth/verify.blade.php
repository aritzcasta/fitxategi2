@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 py-12 px-4">
    <div class="w-full sm:max-w-md">
        <!-- Tarjeta principal -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <div class="flex items-center justify-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h2 class="text-2xl font-bold text-white mb-1">Verifica tu Correo Electrónico</h2>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8">
                @if (session('resent'))
                    <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Se ha enviado un nuevo enlace de verificación a tu correo electrónico
                        </div>
                    </div>
                @endif

                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 mb-6">
                    <div class="flex items-start gap-3 text-left">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-slate-600 dark:text-slate-400">
                            <p class="mb-2">Antes de continuar, por favor revisa tu correo electrónico para encontrar el enlace de verificación.</p>
                            <p>Si no recibiste el correo,</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full group relative overflow-hidden flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-white font-bold text-base transition-all duration-300 shadow-lg hover:shadow-2xl transform hover:-translate-y-1 bg-gradient-to-r from-slate-700 via-slate-800 to-slate-900 hover:from-slate-800 hover:via-slate-900 hover:to-black mb-4">
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white to-transparent opacity-0 group-hover:opacity-20 transform -skew-x-12 group-hover:translate-x-full transition-all duration-1000"></div>
                        <span class="relative z-10">Haz clic aquí para solicitar otro</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver al inicio de sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
