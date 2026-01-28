@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Empresas</h1>
                    <p class="text-sm text-slate-600 dark:text-slate-400">Gestiona las empresas registradas en el sistema</p>
                </div>
            </div>
        </div>

        <!-- Grid de empresas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($empresas as $empresa)
                <a href="{{ route('admin.empresas.show', $empresa->id) }}" 
                   class="group bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 rounded-2xl border-2 border-slate-200 dark:border-slate-700 p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-lg font-bold text-slate-900 dark:text-slate-100 truncate">{{ $empresa->nombre }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">Ver detalles →</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        @if($empresas->isEmpty())
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-12 border border-slate-200 dark:border-slate-700 text-center">
                <svg class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <p class="text-slate-600 dark:text-slate-400 font-medium">No hay empresas registradas</p>
            </div>
        @endif
    </div>
@endsection
