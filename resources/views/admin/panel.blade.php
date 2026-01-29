@extends('layouts.admin')

@section('content')
	<div class="max-w-6xl mx-auto">
		<!-- Header del panel -->
		<div class="mb-8">
			<div class="flex items-center gap-4 mb-2">
				<div class="w-12 h-12 rounded-xl bg-gradient-to-br from-slate-600 to-slate-800 flex items-center justify-center shadow-lg">
					<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
						<rect x="3" y="3" width="7" height="7"></rect>
						<rect x="14" y="3" width="7" height="7"></rect>
						<rect x="14" y="14" width="7" height="7"></rect>
						<rect x="3" y="14" width="7" height="7"></rect>
					</svg>
				</div>
				<div>
					<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Panel Admin</h1>
					<p class="text-sm text-slate-600 dark:text-slate-400">Bienvenido al panel de administración</p>
				</div>
			</div>
		</div>

		<!-- Tarjetas de acceso rápido -->
		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
			<!-- Empresas -->
			<a href="{{ route('admin.empresas') }}" class="group bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 rounded-2xl border-2 border-slate-200 dark:border-slate-700 p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
				<div class="flex items-center gap-4 mb-3">
					<div class="w-12 h-12 rounded-xl bg-slate-700 flex items-center justify-center group-hover:scale-110 transition-transform">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
					</div>
					<div>
						<p class="text-sm font-semibold text-slate-600 dark:text-slate-400">Gestionar</p>
						<p class="text-2xl font-bold text-slate-900 dark:text-slate-100">Empresas</p>
					</div>
				</div>
				<p class="text-xs text-slate-500 dark:text-slate-400">Ver y administrar empresas registradas</p>
			</a>

			<!-- Usuarios -->
			<a href="{{ route('admin.usuarios') }}" class="group bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl border-2 border-blue-200 dark:border-blue-800 p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
				<div class="flex items-center gap-4 mb-3">
					<div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
					</div>
					<div>
						<p class="text-sm font-semibold text-blue-600 dark:text-blue-400">Gestionar</p>
						<p class="text-2xl font-bold text-blue-900 dark:text-blue-100">Usuarios</p>
					</div>
				</div>
				<p class="text-xs text-blue-500 dark:text-blue-400">Ver y administrar usuarios del sistema</p>
			</a>

			<!-- Justificaciones -->
			<a href="{{ route('admin.justificaciones') }}" class="group bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-900/20 rounded-2xl border-2 border-amber-200 dark:border-amber-800 p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
				<div class="flex items-center gap-4 mb-3">
					<div class="w-12 h-12 rounded-xl bg-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
					</div>
					<div>
						<p class="text-sm font-semibold text-amber-600 dark:text-amber-400">Ver</p>
						<p class="text-2xl font-bold text-amber-900 dark:text-amber-100">Justificaciones</p>
					</div>
				</div>
				<p class="text-xs text-amber-500 dark:text-amber-400">Revisar ausencias justificadas</p>
			</a>

			<!-- Festivos -->
			<a href="{{ route('admin.festivos') }}" class="group bg-gradient-to-br from-emerald-50 to-green-100 dark:from-emerald-900/20 dark:to-green-900/20 rounded-2xl border-2 border-emerald-200 dark:border-emerald-800 p-6 shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
				<div class="flex items-center gap-4 mb-3">
					<div class="w-12 h-12 rounded-xl bg-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
					</div>
					<div>
						<p class="text-sm font-semibold text-emerald-600 dark:text-emerald-400">Gestionar</p>
						<p class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">Festivos</p>
					</div>
				</div>
				<p class="text-xs text-emerald-600 dark:text-emerald-400">Crear y borrar días festivos</p>
			</a>
		</div>



		<div class="mt-6">
			@yield('admin.content')
		</div>
	</div>
@endsection

