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
		</div>

		<!-- Información adicional -->
		<div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-6 border border-slate-200 dark:border-slate-700">
			<div class="flex items-start gap-3">
				<svg class="w-6 h-6 text-slate-600 dark:text-slate-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
					<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
				</svg>
				<div>
					<p class="font-semibold text-slate-800 dark:text-slate-200 mb-2">Guía de navegación</p>
					<ul class="text-sm text-slate-600 dark:text-slate-400 space-y-1">
						<li>• Usa la barra lateral para acceder a las diferentes secciones</li>
						<li>• En "Empresas" puedes ver, crear y editar las empresas del sistema</li>
						<li>• En "Usuarios" puedes gestionar los usuarios y sus permisos</li>
						<li>• En "Justificaciones" puedes revisar las ausencias reportadas</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="mt-6">
			@yield('admin.content')
		</div>
	</div>
@endsection

