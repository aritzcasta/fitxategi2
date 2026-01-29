@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Usuarios</h2>

            <div class="mt-4">
                <table class="w-full text-left table-auto">
                    <thead>
                        <tr class="text-sm text-gray-600 dark:text-gray-300">
                            <th class="py-2">Nombre</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Rol</th>
                            <th class="py-2">Empresa</th>
                            <th class="py-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700 dark:text-gray-200">
                        @foreach($users as $user)
                            <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors duration-150">
                                <td class="py-3">
                                    <a href="{{ route('admin.usuarios.edit', $user->id) }}" class="text-indigo-600 hover:underline">{{ $user->nombre }}</a>
                                </td>
                                <td class="py-3">{{ $user->email }}</td>
                                <td class="py-3">{{ $user->rol?->nombre }}</td>
                                <td class="py-3">{{ $user->empresa?->nombre }}</td>
                                <td class="py-3">
                                    @php
                                        $color = 'bg-red-500';
                                        if ($user->status === 'green') $color = 'bg-emerald-500';
                                        if ($user->status === 'yellow') $color = 'bg-yellow-400';
                                    @endphp
                                    <span class="inline-block w-3 h-3 rounded-full {{ $color }} mr-2 align-middle"></span>
                                    @if ($user->status === 'green')
                                        <span class="align-middle">Registrado a tiempo</span>
                                    @elseif ($user->status === 'yellow')
                                        <span class="align-middle">Registrado hoy (tarde)</span>
                                    @else
                                        <span class="align-middle">No registrado hoy</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
