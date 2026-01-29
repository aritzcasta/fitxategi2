@extends('layouts.admin')

@section('content')
	<div class="space-y-6">
		<!-- Header -->
		<div class="mb-8">
			<div class="flex items-center gap-4 mb-2">
				<div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-600 to-orange-700 flex items-center justify-center shadow-lg">
					<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
						<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
					</svg>
				</div>
				<div>
					<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">Justificaciones</h1>
					<p class="text-sm text-slate-600 dark:text-slate-400">Listado de fichajes justificados con motivo y foto opcional</p>
				</div>
			</div>
		</div>

		<!-- Filtros -->
		<div class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-800 dark:to-slate-900 border-2 border-slate-200 dark:border-slate-700 rounded-2xl p-6 shadow-lg">
			<form method="GET" action="{{ route('admin.justificaciones') }}" class="flex flex-col sm:flex-row gap-4 sm:items-end">
				<div class="flex-1">
					<label for="desde" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Desde</label>
					<input id="desde" 
						   name="desde" 
						   type="date" 
						   value="{{ $desde }}" 
						   class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition" />
				</div>
				<div class="flex-1">
					<label for="hasta" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-2">Hasta</label>
					<input id="hasta" 
						   name="hasta" 
						   type="date" 
						   value="{{ $hasta }}" 
						   class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-gray-100 focus:border-slate-600 focus:ring-4 focus:ring-slate-200 dark:focus:ring-slate-700 transition" />
				</div>
				<div class="flex gap-3">
					<button type="submit" 
							class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-white bg-gradient-to-r from-slate-700 to-slate-800 hover:from-slate-800 hover:to-slate-900 transition-all duration-200 shadow-lg hover:shadow-xl">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
						</svg>
						Filtrar
					</button>
					<a href="{{ route('admin.justificaciones') }}" 
					   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-100 dark:hover:bg-slate-600 transition-all duration-200 shadow-md border-2 border-slate-200 dark:border-slate-600">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
							<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
						</svg>
						Limpiar
					</a>
				</div>
			</form>
		</div>

		<!-- Tabla -->
		<div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
			<div class="overflow-x-auto">
				<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
					<thead class="bg-gradient-to-r from-slate-700 to-slate-800">
						<tr>
							<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Fecha</th>
							<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Usuario</th>
							<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Correo</th>
							<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Imagen</th>
							<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Motivo</th>
							<th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">Estado</th>
						</tr>
					</thead>
					<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
						@forelse ($justificaciones as $j)
							<tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors duration-150">
								<td class="px-6 py-4 whitespace-nowrap">
									<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300">
										<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
											<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
										</svg>
										{{ optional($j->fecha)->format('d/m/Y') }}
									</span>
								</td>
								<td class="px-6 py-4">
									<div class="flex items-center gap-3">
										<div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-600 to-orange-700 flex items-center justify-center text-white font-bold shadow-md">
											{{ strtoupper(substr($j->usuario->nombre ?? 'U', 0, 1)) }}
										</div>
										<span class="text-sm font-semibold text-slate-700 dark:text-slate-300">
											{{ $j->usuario->nombre ?? '—' }}
										</span>
									</div>
								</td>
								<td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
									{{ $j->usuario->email ?? '—' }}
								</td>
								<td class="px-6 py-4">
									@if (!empty($j->justificacion_foto))
										<img
											src="{{ asset($j->justificacion_foto) }}"
											alt="Justificación"
											class="js-zoomable h-16 w-16 object-cover rounded-xl border-2 border-slate-200 dark:border-slate-700 cursor-zoom-in shadow-md hover:shadow-xl transition-shadow"
											data-full="{{ asset($j->justificacion_foto) }}"
										/>
									@else
										<span class="inline-flex items-center gap-1 text-xs text-slate-500 dark:text-slate-400">
											<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
											</svg>
											Sin imagen
										</span>
									@endif
								</td>
								<td class="px-6 py-4">
									<div class="max-w-md text-sm text-slate-700 dark:text-slate-300 whitespace-pre-wrap break-words">
										{{ $j->justificacion }}
									</div>
								</td>
								<td class="px-6 py-4">
									@php($estado = $j->justificacion_estado ?? 'Pendiente')
									<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300">
										{{ $estado }}
									</span>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="px-6 py-12 text-center">
									<svg class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
									</svg>
									<p class="text-slate-600 dark:text-slate-400 font-medium">No hay justificaciones para los filtros actuales</p>
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
		</div>

		<!-- Paginación -->
		<div>
			{{ $justificaciones->links() }}
		</div>
	</div>

	{{-- Lightbox simple para ampliar/restaurar imagen al hacer click --}}
	<script>
		(function () {
			function closeLightbox() {
				const overlay = document.getElementById('js-lightbox-overlay');
				if (overlay) overlay.remove();
			}

			function openLightbox(src) {
				closeLightbox();

				const overlay = document.createElement('div');
				overlay.id = 'js-lightbox-overlay';
				overlay.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-6';
				overlay.addEventListener('click', closeLightbox);

				const img = document.createElement('img');
				img.src = src;
				img.alt = 'Justificación';
				img.className = 'max-h-[90vh] max-w-[90vw] rounded-lg shadow-2xl border border-white/10 cursor-zoom-out';
				img.addEventListener('click', function (e) {
					e.stopPropagation();
					closeLightbox();
				});

				overlay.appendChild(img);
				document.body.appendChild(overlay);
			}

			document.addEventListener('click', function (e) {
				const target = e.target;
				if (!target || !target.classList) return;

				if (target.classList.contains('js-zoomable')) {
					const src = target.getAttribute('data-full') || target.getAttribute('src');
					if (src) openLightbox(src);
				}
			});

			document.addEventListener('keydown', function (e) {
				if (e.key === 'Escape') closeLightbox();
			});
		})();
	</script>
@endsection
