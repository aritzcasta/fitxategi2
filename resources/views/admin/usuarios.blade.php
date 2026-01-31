@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Usuarios</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Gestiona los usuarios registrados en el sistema</p>
                </div>
            </div>
        </div>

        <!-- Tabla de usuarios -->
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-br from-blue-600 to-indigo-700">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Nombre</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Email</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Rol</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Empresa</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-blue-500 dark:hover:bg-indigo-800/50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.usuarios.edit', $user->id) }}"
                                       class="flex items-center gap-3 group">
                                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white font-bold shadow-md">
                                            {{ strtoupper(substr($user->nombre, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 group-hover:text-slate-900 dark:group-hover:text-slate-100">
                                            {{ $user->nombre }}
                                        </span>
                                    </a>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
                                        {{ $user->rol?->nombre ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $user->empresa?->nombre ?? '—' }}</td>
                                <td class="px-6 py-4">
                                    @php
                                        $color = 'bg-red-500';
                                        $bgColor = 'bg-red-50 dark:bg-red-900/20';
                                        $textColor = 'text-red-700 dark:text-red-300';
                                        $statusText = 'No registrado hoy';

                                        if ($user->status === 'green') {
                                            $color = 'bg-emerald-500';
                                            $bgColor = 'bg-emerald-50 dark:bg-emerald-900/20';
                                            $textColor = 'text-emerald-700 dark:text-emerald-300';
                                            $statusText = 'Registrado a tiempo';
                                        } elseif ($user->status === 'yellow') {
                                            $color = 'bg-yellow-400';
                                            $bgColor = 'bg-yellow-50 dark:bg-yellow-900/20';
                                            $textColor = 'text-yellow-700 dark:text-yellow-300';
                                            $statusText = 'Registrado tarde';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $bgColor }} {{ $textColor }}">
                                        <span class="w-2 h-2 rounded-full {{ $color }}"></span>
                                        {{ $statusText }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->isEmpty())
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-12 border border-slate-200 dark:border-slate-700 text-center mt-6">
                <svg class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
                <p class="text-slate-600 dark:text-slate-400 font-medium">No hay usuarios registrados</p>
            </div>
        @endif
    </div>
@endsection
