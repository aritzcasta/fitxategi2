@extends('layouts.admin')

@section('content')
    <div class="max-w-6xl mx-auto">
        <h2 class="text-xl font-semibold mb-4">Empresas</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($empresas as $empresa)
                <a href="{{ route('admin.empresas.show', $empresa->id) }}" class="block p-4 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition">
                    <div class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $empresa->nombre }}</div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
