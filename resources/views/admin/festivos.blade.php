@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        <div class="flex items-center gap-4 mb-2">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-500 to-red-600 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Festivos</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Gestiona los días festivos marcados por el administrador</p>
            </div>
        </div>

        @if (session('status'))
            <div class="px-6 py-4 rounded-2xl text-sm font-medium shadow border bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-br from-rose-500 to-red-600 px-8 py-6">
                <h2 class="text-xl font-bold text-white">Añadir festivo</h2>
                <p class="text-slate-300 text-sm">Puedes añadir varias fechas sueltas o un rango (desde/hasta)</p>
            </div>

            <form method="POST" action="{{ route('admin.festivos.store') }}" class="p-8 space-y-4">
                @csrf

                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Fechas (opcional)</label>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="desde" class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-2">Desde (opcional)</label>
                            <input id="desde" name="desde" type="date" value="{{ old('desde') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('desde') ? 'border-red-300 dark:border-red-700' : 'border-slate-200 dark:border-slate-600' }} bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-red-600 dark:focus:border-red-500 focus:bg-white dark:focus:bg-slate-600 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 transition">
                            @error('desde')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="hasta" class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-2">Hasta (opcional)</label>
                            <input id="hasta" name="hasta" type="date" value="{{ old('hasta') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('hasta') ? 'border-red-300 dark:border-red-700' : 'border-slate-200 dark:border-slate-600' }} bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-red-600 dark:focus:border-red-500 focus:bg-white dark:focus:bg-slate-600 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 transition">
                            @error('hasta')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="nombre" class="block text-xs font-semibold text-gray-600 dark:text-gray-300 mb-2">Descripción (opcional)</label>
                            <input id="nombre" name="nombre" type="text" value="{{ old('nombre') }}"
                                   class="w-full px-4 py-3 rounded-xl border-2 {{ $errors->has('nombre') ? 'border-red-300 dark:border-red-700' : 'border-slate-200 dark:border-slate-600' }} bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-red-600 dark:focus:border-red-500 focus:bg-white dark:focus:bg-slate-600 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 transition"
                                   placeholder="Ej: Navidad, Día de la Comunidad...">
                            @error('nombre')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="text-xs text-slate-600 dark:text-slate-300">
                        Si rellenas <span class="font-semibold">Desde</span> y <span class="font-semibold">Hasta</span>, se marcarán todos los días del rango (incluidos). Si no, puedes añadir fechas sueltas abajo.
                    </div>

                    <div id="fechas-container" class="space-y-2">
                        <input name="fechas[]" type="date"
                               class="w-full px-4 py-3 rounded-xl border-2 {{ ($errors->has('fechas') || $errors->has('fechas.*')) ? 'border-red-300 dark:border-red-700' : 'border-slate-200 dark:border-slate-600' }} bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-red-600 dark:focus:border-red-500 focus:bg-white dark:focus:bg-slate-600 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 transition">
                    </div>
                    @error('fechas')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    @error('fechas.*')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    <div class="flex items-center gap-2">
                        <button type="button" id="add-fecha" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold bg-slate-100 dark:bg-slate-700 text-gray-800 dark:text-gray-100 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14" stroke-linecap="round" />
                            </svg>
                            Añadir otra fecha
                        </button>
                        <button type="button" id="remove-fecha" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold bg-slate-100 dark:bg-slate-700 text-gray-800 dark:text-gray-100 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                            Quitar última
                        </button>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl text-sm font-semibold text-white bg-slate-800 hover:bg-slate-900 transition-all duration-200 shadow-md hover:shadow-lg">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" stroke-linecap="round" />
                        </svg>
                        Guardar festivos
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
            <form method="POST" action="{{ route('admin.festivos.destroyMany') }}" onsubmit="return confirm('¿Eliminar los festivos seleccionados?')">
                @csrf
                @method('DELETE')

                <div class="flex items-center justify-between gap-3 px-4 py-3 bg-gray-50 dark:bg-gray-900/40">
                    <label class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-200">
                        <input id="select-all" type="checkbox" class="rounded border-gray-300">
                        Seleccionar todo
                    </label>

                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                        Eliminar seleccionados
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900/40">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Sel.</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Fecha</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Descripción</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($festivos as $festivo)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20">
                                    <td class="px-4 py-3 text-sm">
                                        <input type="checkbox" name="ids[]" value="{{ $festivo->id }}" class="js-row-checkbox rounded border-gray-300">
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100 whitespace-nowrap">
                                        {{ optional($festivo->fecha)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                        {{ $festivo->nombre ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right">
                                        <form method="POST" action="{{ route('admin.festivos.destroy', $festivo->id) }}" onsubmit="return confirm('¿Eliminar este festivo?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-sm text-gray-500">No hay festivos guardados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function () {
            var container = document.getElementById('fechas-container');
            var btnAdd = document.getElementById('add-fecha');
            var btnRemove = document.getElementById('remove-fecha');

            function newFechaInput() {
                var input = document.createElement('input');
                input.type = 'date';
                input.name = 'fechas[]';
                input.className = 'w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-red-600 dark:focus:border-red-500 focus:bg-white dark:focus:bg-slate-600 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 transition';
                return input;
            }

            if (btnAdd && container) {
                btnAdd.addEventListener('click', function () {
                    container.appendChild(newFechaInput());
                });
            }

            if (btnRemove && container) {
                btnRemove.addEventListener('click', function () {
                    var inputs = container.querySelectorAll('input[name="fechas[]"]');
                    if (inputs.length > 1) {
                        inputs[inputs.length - 1].remove();
                    }
                });
            }

            var selectAll = document.getElementById('select-all');
            if (selectAll) {
                selectAll.addEventListener('change', function () {
                    var checked = !!selectAll.checked;
                    document.querySelectorAll('.js-row-checkbox').forEach(function (cb) {
                        cb.checked = checked;
                    });
                });
            }
        })();
    </script>
@endsection
