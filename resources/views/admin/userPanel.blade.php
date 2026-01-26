@extends('layouts.app')

@section('content')
<div x-data="{ showModal: false, search: '{{ request('search') }}' }">
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Header -->
        <div class="bg-white dark:bg-gray-800 shadow sticky top-0 z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                        Gestión de Usuarios
                    </h2>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

            <!-- Actions Bar -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <form action="{{ route('userPanel.search') }}" method="GET" x-ref="searchForm">
                            <div class="relative">
                                <input type="text"
                                    name="search"
                                    x-model="search"
                                    @input.debounce.500ms="$refs.searchForm.submit()"
                                    placeholder="Buscar Usuarios..."
                                    class="w-full pl-10 pr-10 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent">

                                <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>

                                <button type="button"
                                        x-show="search && search.length > 0"
                                        @click.prevent="search = ''; $nextTick(() => $refs.searchForm.submit())"
                                        class="absolute right-3 top-2.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Filter & Add Button -->
                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filtros
                        </button>
                        <button @click="showModal = true" type="button" class="px-4 py-2 bg-gray-800 dark:bg-gray-700 hover:bg-gray-900 dark:hover:bg-gray-600 text-white rounded-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Nuevo Usuario
                        </button>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Email
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Rol
                                </th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @if(isset($users))
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{$user->name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{$user->email}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($user->role_id==3)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300">
                                                    Admin
                                                </span>
                                            @elseif ($user->role_id==2)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300">
                                                    Profesor
                                                </span>
                                            @elseif ($user->role_id==1)
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-300">
                                                    Usuario
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex items-center gap-2">
                                                <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Mostrando
                            <span class="font-medium">{{ $users->firstItem() }}</span>
                            a
                            <span class="font-medium">{{ $users->lastItem() }}</span>
                            de
                            <span class="font-medium">{{ $users->total() }}</span>
                            resultados
                        </div>
                        @if($users->hasPages())
                            <div class="flex gap-2">
                                @if ($users->onFirstPage())
                                    <span class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-400 cursor-not-allowed opacity-50">
                                        Anterior
                                    </span>
                                @else
                                    <a href="{{ $users->previousPageUrl() }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        Anterior
                                    </a>
                                @endif

                                @for ($i = 1; $i <= $users->lastPage(); $i++)
                                    @if ($i == $users->currentPage())
                                        <span class="px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-lg">
                                            {{ $i }}
                                        </span>
                                    @else
                                        <a href="{{ $users->url($i) }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                                            {{ $i }}
                                        </a>
                                    @endif
                                @endfor

                                @if ($users->hasMorePages())
                                    <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                                        Siguiente
                                    </a>
                                @else
                                    <span class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-400 cursor-not-allowed opacity-50">
                                        Siguiente
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mt-4 p-4 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mt-4 p-4 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <template x-if="showModal">
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <!-- Backdrop -->
            <div @click="showModal = false" class="fixed inset-0 bg-black bg-opacity-50 transition-opacity"></div>

            <!-- Modal Content -->
            <div class="flex min-h-screen items-center justify-center p-4">
                <div @click.stop
                     class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-md p-6">

                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Nuevo Usuario
                        </h3>
                        <button @click="showModal = false" type="button" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('userPanel.store') }}" method="POST">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nombre
                            </label>
                            <input type="text"
                                   name="name"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent">
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email
                            </label>
                            <input type="email"
                                   name="email"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent">
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Contraseña
                            </label>
                            <input type="password"
                                   name="password"
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent">
                        </div>

                        <!-- Role -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Rol
                            </label>
                            <select name="role_id"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-gray-900 dark:focus:ring-white focus:border-transparent">
                                <option value="1">Admin</option>
                                <option value="2">Usuario</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 justify-end">
                            <button type="button"
                                    @click="showModal = false"
                                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                                Cancelar
                            </button>
                            <button type="submit"
                                    class="px-4 py-2 bg-gray-800 dark:bg-gray-700 hover:bg-gray-900 dark:hover:bg-gray-600 text-white rounded-lg">
                                Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection
