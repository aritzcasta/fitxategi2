@extends('layouts.admin')

@section('content')
	<div class="space-y-6">
		<div class="flex items-start justify-between gap-4">
			<div>
				<h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Justificaciones</h1>
				<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Listado de fichajes justificados (con motivo y foto opcional).</p>
			</div>
		</div>

		<div class="bg-gray-50 dark:bg-gray-900/30 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
			<form method="GET" action="{{ route('admin.justificaciones') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
				<div class="flex flex-col">
					<label for="desde" class="text-sm text-gray-700 dark:text-gray-200">Desde</label>
					<input id="desde" name="desde" type="date" value="{{ $desde }}" class="mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm" />
				</div>
				<div class="flex flex-col">
					<label for="hasta" class="text-sm text-gray-700 dark:text-gray-200">Hasta</label>
					<input id="hasta" name="hasta" type="date" value="{{ $hasta }}" class="mt-1 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-md px-3 py-2 text-sm" />
				</div>
				<div class="flex gap-2">
					<button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm">Filtrar</button>
					<a href="{{ route('admin.justificaciones') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-100 px-4 py-2 rounded-md text-sm">Limpiar</a>
				</div>
			</form>
		</div>

		<div class="overflow-x-auto bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg">
			<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
				<thead class="bg-gray-50 dark:bg-gray-900/40">
					<tr>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Fecha</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Nombre</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Correo</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Imagen</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Motivo</th>
						<th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Estado</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 dark:divide-gray-700">
					@forelse ($justificaciones as $j)
						<tr class="hover:bg-gray-50 dark:hover:bg-gray-900/20">
							<td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100 whitespace-nowrap">
								{{ optional($j->fecha)->format('Y-m-d') }}
							</td>
							<td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">
								{{ $j->usuario->nombre ?? '—' }}
							</td>
							<td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-300">
								{{ $j->usuario->email ?? '—' }}
							</td>
							<td class="px-4 py-3 text-sm">
								@if (!empty($j->justificacion_foto))
									<img
										src="{{ asset($j->justificacion_foto) }}"
										alt="Justificación"
										class="js-zoomable h-14 w-14 object-cover rounded-md border border-gray-200 dark:border-gray-700 cursor-zoom-in"
										data-full="{{ asset($j->justificacion_foto) }}"
									/>
								@else
									<span class="text-xs text-gray-500">(sin imagen)</span>
								@endif
							</td>
							<td class="px-4 py-3 text-sm text-gray-800 dark:text-gray-100">
								<div class="max-w-xl whitespace-pre-wrap break-words">{{ $j->justificacion }}</div>
							</td>
							<td class="px-4 py-3 text-sm">
								@php($estado = $j->justificacion_estado ?? '—')
								<span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100">
									{{ $estado }}
								</span>
							</td>
						</tr>
					@empty
						<tr>
							<td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">No hay justificaciones para los filtros actuales.</td>
						</tr>
					@endforelse
				</tbody>
			</table>
		</div>

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
