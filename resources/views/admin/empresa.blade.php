@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold">Usuarios en {{ $empresa->nombre }}</h2>
            <div class="flex items-center gap-2">
                @php
                    $excelBase = route('admin.empresas.export.excel', $empresa->id);
                    $pdfBase = route('admin.empresas.export.pdf', $empresa->id);
                @endphp
                <a href="#" id="export-excel" data-base-url="{{ $excelBase }}" class="inline-block px-3 py-2 bg-green-600 text-white rounded-md text-sm">Exportar Excel</a>
                <a href="#" id="export-pdf" data-base-url="{{ $pdfBase }}" class="inline-block px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md text-sm">Exportar PDF</a>
            </div>
        </div>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            @if($usuarios->isEmpty())
                <p class="text-sm text-gray-500">No hay usuarios asociados a esta empresa (sin contar administradores).</p>
            @else
                <ul id="usuarios-list" class="space-y-2">
                    @foreach($usuarios as $user)
                        @php
                            $last = $user->fichajes->first();
                        @endphp
                        <li data-user-id="{{ $user->id }}" class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-3 border-b border-gray-100 dark:border-gray-700">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                @if($user->fecha_fin)
                                    <div class="text-xs text-gray-500">Fin prácticas: {{ $user->fecha_fin->format('Y-m-d') }}</div>
                                @endif
                            </div>

                            <div class="mt-2 sm:mt-0 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-300">
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Fichajes:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->fichajes_count }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Veces registradas:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->veces_registradas ?? 0 }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Faltas justificadas:</span>
                                    <span class="font-medium text-gray-900 dark:text-gray-100">{{ $user->faltas_justificadas ?? 0 }}</span>
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-500">Último fichaje:</span>
                                    @if($last)
                                        <span class="font-medium text-gray-900 dark:text-gray-100">{{ $last->fecha->format('Y-m-d') }} {{ $last->hora_entrada ? '· E:'.$last->hora_entrada : '' }}{{ $last->hora_salida ? ' S:'.$last->hora_salida : '' }}</span>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <script>
        (function(){
            function collectVisibleIds(){
                var list = document.getElementById('usuarios-list');
                if(!list) return [];
                var ids = [];
                Array.prototype.forEach.call(list.querySelectorAll('li[data-user-id]'), function(li){
                    if(li.offsetParent !== null){
                        var id = li.getAttribute('data-user-id');
                        if(id) ids.push(id);
                    }
                });
                return ids;
            }

            function handleExportClick(e, baseSelector){
                e.preventDefault();
                var base = e.currentTarget.getAttribute('data-base-url') || baseSelector;
                var ids = collectVisibleIds();
                var url = base;
                if(ids.length) url += '?users=' + ids.join(',');
                window.location.href = url;
            }

            var btnExcel = document.getElementById('export-excel');
            if(btnExcel) btnExcel.addEventListener('click', function(e){ handleExportClick(e); });
            var btnPdf = document.getElementById('export-pdf');
            if(btnPdf) btnPdf.addEventListener('click', function(e){ handleExportClick(e); });
        })();
    </script>
@endsection
