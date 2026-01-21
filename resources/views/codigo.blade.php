@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 text-center">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Código de inicio</h1>
        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Válido 15 segundos</p>

        <div id="codigo" class="mt-6 text-5xl font-bold tracking-widest text-indigo-600">{{ $codigo->codigo }}</div>
        <div id="contador" class="mt-2 text-sm text-gray-500 dark:text-gray-400"></div>
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
