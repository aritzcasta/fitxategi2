@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-zinc-100 dark:from-slate-900 dark:via-gray-900 dark:to-zinc-900 flex items-center justify-center px-4">
    <div class="w-full max-w-lg">
        <!-- Tarjeta Principal -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-slate-700 to-slate-800 px-8 py-6">
                <div class="flex items-center justify-center gap-4">
                    <div class="w-14 h-14 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <div class="text-center">
                        <h1 class="text-2xl font-bold text-white mb-1">Código de Acceso</h1>
                        <p class="text-slate-300 text-sm">Código temporal para fichar</p>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div class="p-8 text-center">
                <!-- Código -->
                <div class="mb-6">
                    <div id="codigo" class="text-6xl font-bold tracking-[0.5em] text-transparent bg-clip-text bg-gradient-to-r from-slate-700 to-slate-900 dark:from-slate-300 dark:to-slate-100 mb-3 animate-pulse">
                        {{ $codigo->codigo }}
                    </div>
                    <div class="flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <span id="contador" class="font-semibold text-amber-700 dark:text-amber-400"></span>
                    </div>
                </div>

               

                <!-- Botón Volver -->
                <div class="mt-6">
                    <a href="{{ route('home') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver al inicio
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function () {
        const codigoEl = document.getElementById('codigo');
        const contadorEl = document.getElementById('contador');

        async function refrescarCodigo() {
            const res = await fetch('{{ route('codigo.actual') }}', { cache: 'no-store' });
            const data = await res.json();
            codigoEl.textContent = data.codigo;

            const expiresAt = new Date(data.expires_at);
            const diff = Math.max(0, Math.floor((expiresAt - new Date()) / 1000));
            contadorEl.textContent = `Caduca en ${diff}s`;
        }

        refrescarCodigo();
        setInterval(refrescarCodigo, 1000);
    })();
</script>
@endsection
