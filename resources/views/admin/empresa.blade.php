@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto">
        <h2 class="text-xl font-semibold">Usuarios en {{ $empresa->nombre }}</h2>
        <div class="mt-4 bg-white dark:bg-gray-800 shadow rounded-lg p-4">
            @if($empresa->usuarios->isEmpty())
                <p class="text-sm text-gray-500">No hay usuarios asociados a esta empresa.</p>
            @else
                <ul class="space-y-2">
                    @foreach($empresa->usuarios as $user)
                        <li class="flex items-center justify-between p-2 border-b border-gray-100 dark:border-gray-700">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $user->nombre }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                            <div class="text-sm text-gray-500">{{ $user->rol?->nombre }}</div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
