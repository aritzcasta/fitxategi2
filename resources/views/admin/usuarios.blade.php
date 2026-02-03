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

            <div class="mt-4">
                <form action="{{ route('admin.usuarios') }}" method="GET" class="max-w-md">
                    <div class="flex items-center bg-slate-50 dark:bg-slate-800 rounded-xl px-4 py-2.5 border-2 border-slate-200 dark:border-slate-700 focus-within:border-blue-600 dark:focus-within:border-blue-500 transition">
                        <svg class="w-5 h-5 text-slate-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre, email o empresa..." class="bg-transparent focus:outline-none text-sm text-gray-800 dark:text-gray-200 w-full" />
                        @if(request('buscar'))
                            <a href="{{ route('admin.usuarios') }}" class="ml-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800">
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

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
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-white">Cambiar Rol</th>
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
                                <td class="px-6 py-4">
                                    <button type="button"
                                            onclick="mostrarModalCambiarRol({{ $user->id }}, '{{ addslashes($user->nombre) }}', '{{ $user->rol?->nombre }}')"
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition-all duration-200 shadow-md hover:shadow-lg
                                            {{ $user->rol?->nombre === 'admin' ? 'bg-slate-600 hover:bg-slate-700 text-white' : 'bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white' }}">
                                        @if($user->rol?->nombre === 'admin')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            Hacer Usuario
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            Hacer Admin
                                        @endif
                                    </button>
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

    <!-- Modal de confirmación para cambiar rol -->
    <div id="modal-cambiar-rol" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 px-4">
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md transform transition-all border-2 border-purple-500 dark:border-purple-700">
            <!-- Header del modal -->
            <div id="modal-header" class="bg-gradient-to-r from-purple-600 to-indigo-600 px-8 py-6 rounded-t-3xl">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">Confirmar Cambio de Rol</h2>
                        <p class="text-purple-100 text-sm">Esta acción modificará los permisos del usuario</p>
                    </div>
                </div>
            </div>

            <!-- Cuerpo del modal -->
            <form id="form-cambiar-rol" method="POST" action="" class="p-8">
                @csrf
                @method('PATCH')
                
                <div class="mb-6">
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <span id="modal-mensaje"></span>
                    </p>
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800">
                        <p class="text-sm text-purple-700 dark:text-purple-300 font-semibold">
                            <span id="modal-info"></span>
                        </p>
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="button"
                            onclick="cerrarModalCambiarRol()"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 border-2 border-gray-200 dark:border-gray-600">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="flex-1 px-6 py-4 rounded-xl font-semibold text-white bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
    function mostrarModalCambiarRol(userId, userName, userRol) {
        const modal = document.getElementById('modal-cambiar-rol');
        const form = document.getElementById('form-cambiar-rol');
        const mensaje = document.getElementById('modal-mensaje');
        const info = document.getElementById('modal-info');
        
        form.action = `/admin/usuarios/${userId}/cambiar-rol`;
        
        if (userRol === 'admin') {
            mensaje.innerHTML = `¿Seguro que quieres cambiar a <strong class="text-slate-600 dark:text-slate-400">${userName}</strong> de <strong>Administrador</strong> a <strong>Usuario Normal</strong>?`;
            info.textContent = 'El usuario perderá todos los permisos administrativos del sistema.';
        } else {
            mensaje.innerHTML = `¿Seguro que quieres hacer <strong class="text-purple-600 dark:text-purple-400">${userName}</strong> <strong>Administrador</strong>?`;
            info.textContent = 'El usuario obtendrá acceso completo al panel de administración y podrá gestionar otros usuarios, empresas y configuraciones del sistema.';
        }
        
        modal.classList.remove('hidden');
    }

    function cerrarModalCambiarRol() {
        const modal = document.getElementById('modal-cambiar-rol');
        modal.classList.add('hidden');
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('modal-cambiar-rol')?.addEventListener('click', function(e) {
        if (e.target === this) {
            cerrarModalCambiarRol();
        }
    });
    </script>
@endsection
