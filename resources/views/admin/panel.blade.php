@extends('layouts.admin')

@section('content')
	<div class="max-w-6xl mx-auto">
		<div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
			<h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Panel Admin</h1>
			<p class="text-sm text-gray-500 mt-2">Bienvenido al panel de administración. Usa la barra lateral para navegar.</p>

			<div class="mt-6">
				@yield('admin.content')
			</div>
		</div>
	</div>
@endsection

