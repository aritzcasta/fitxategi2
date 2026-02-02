@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4 mb-2">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Borrar Usuarios</h1>
                <p class="text-sm text-slate-600 dark:text-slate-400">Gestiona la eliminación permanente de usuarios del sistema</p>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-6 px-6 py-4 rounded-2xl text-sm font-medium shadow-lg border {{ session('error') ? 'bg-red-50 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-200 dark:border-red-800' : 'bg-emerald-50 text-emerald-800 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800' }}">
            <div class="flex items-center gap-3">
                @if (session('error'))
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                @endif
                {{ session('status') }}
            </div>
        </div>
    @endif

 
    <!-- Tabla de usuarios -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-br from-red-600 to-red-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Usuario</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Empresa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Fichajes</th>
                        <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-white">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($usuarios as $usuario)
                        <tr class="hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors duration-150">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center text-white font-bold shadow-md">
                                        {{ strtoupper(substr($usuario->nombre, 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
                                        {{ $usuario->nombre }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $usuario->empresa?->nombre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">{{ $usuario->fichajes_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-right">
                                <button onclick="mostrarModalBorrar({{ $usuario->id }}, '{{ addslashes($usuario->nombre) }}')" 
                                        type="button"
                                        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold bg-red-600 text-white hover:bg-red-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-16 h-16 text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                    </svg>
                                    <p class="text-slate-600 dark:text-slate-400 font-medium">No hay usuarios disponibles para eliminar</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div id="modal-borrar" class="hidden fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 px-4">
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-2xl w-full max-w-md transform transition-all border-2 border-red-500 dark:border-red-700">
        <!-- Header del modal -->
        <div class="bg-gradient-to-r from-red-600 to-red-700 px-8 py-6 rounded-t-3xl">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 bg-white/10 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">Confirmación Requerida</h2>
                    <p class="text-red-100 text-sm">Esta acción es irreversible</p>
                </div>
            </div>
        </div>

        <!-- Cuerpo del modal -->
        <form id="form-borrar" method="POST" action="" class="p-8">
            @csrf
            @method('DELETE')
            
            <div class="mb-6">
                <p class="text-gray-700 dark:text-gray-300 mb-4">
                    Estás a punto de eliminar al usuario <strong id="usuario-nombre" class="text-red-600 dark:text-red-400"></strong>.
                </p>
                <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-200 dark:border-red-800 mb-4">
                    <p class="text-sm text-red-700 dark:text-red-300 font-semibold">
                        Esta acción eliminará permanentemente todos los datos del usuario, incluyendo fichajes y justificaciones.
                    </p>
                </div>
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                    Para confirmar, escribe <span class="text-red-600 dark:text-red-400 font-bold">borrar</span> en el campo de abajo:
                </label>
                <input type="text" 
                       id="confirmacion" 
                       class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:border-red-600 dark:focus:border-red-500 focus:bg-white dark:focus:bg-gray-600 focus:ring-4 focus:ring-red-200 dark:focus:ring-red-700 transition"
                       placeholder="Escribe 'borrar' para confirmar"
                       required>
            </div>
            
            <div class="flex gap-3">
                <button type="button"
                        onclick="cerrarModalBorrar()"
                        class="flex-1 px-6 py-4 rounded-xl font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-200 border-2 border-gray-200 dark:border-gray-600">
                    Cancelar
                </button>
                <button type="submit"
                        id="btn-confirmar"
                        disabled
                        class="flex-1 px-6 py-4 rounded-xl font-semibold text-white bg-red-600 hover:bg-red-700 disabled:bg-gray-400 disabled:cursor-not-allowed transition-all duration-200 shadow-lg hover:shadow-xl">
                    Eliminar Usuario
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function mostrarModalBorrar(userId, userName) {
    const modal = document.getElementById('modal-borrar');
    const form = document.getElementById('form-borrar');
    const nombreSpan = document.getElementById('usuario-nombre');
    const confirmInput = document.getElementById('confirmacion');
    const btnConfirmar = document.getElementById('btn-confirmar');
    
    form.action = `/admin/borrar-usuarios/${userId}`;
    nombreSpan.textContent = userName;
    confirmInput.value = '';
    btnConfirmar.disabled = true;
    
    modal.classList.remove('hidden');
    
    // Habilitar botón solo si escribe "borrar"
    confirmInput.addEventListener('input', function() {
        btnConfirmar.disabled = this.value.toLowerCase() !== 'borrar';
    });
}

function cerrarModalBorrar() {
    const modal = document.getElementById('modal-borrar');
    modal.classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('modal-borrar')?.addEventListener('click', function(e) {
    if (e.target === this) {
        cerrarModalBorrar();
    }
});
</script>
@endsection
