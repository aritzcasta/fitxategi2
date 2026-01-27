@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold">Usuarios en {{ $empresa->nombre }}</h2>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            @if($usuarios->isEmpty())
                <p class="text-sm text-gray-500">No hay usuarios asociados a esta empresa (sin contar administradores).</p>
            @else
                <ul class="space-y-2">
                    @foreach($usuarios as $user)
                        @php
                            $last = $user->fichajes->first();
                        @endphp
                        <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                @if($user->fecha_fin)
                                    <div class="text-xs text-gray-500">Fin prácticas: {{ $user->fecha_fin->format('Y-m-d') }}</div>
                                @endif
                            </div>

                            <div class="mt-2 sm:mt-0 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Fichajes:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->fichajes_count }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Veces registradas:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->veces_registradas ?? 0 }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Faltas justificadas:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->faltas_justificadas ?? 0 }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Último fichaje:</span>
                                    @if($last)
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $last->fecha->format('Y-m-d') }} {{ $last->hora_entrada ? '· E:'.$last->hora_entrada : '' }}{{ $last->hora_salida ? ' S:'.$last->hora_salida : '' }}</span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
