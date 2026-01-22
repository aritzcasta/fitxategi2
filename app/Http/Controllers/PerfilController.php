<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use App\Models\Incidencia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PerfilController extends Controller
{
    public function show(): View
    {
        $usuario = Auth::user();

        $incidencias = Incidencia::where('id_usuario', $usuario->id)->count();
        $llegadasTarde = Fichaje::where('id_usuario', $usuario->id)
            ->where('estado', 'tarde')
            ->count();

        $horasRestantes = null;
        if ($usuario->fecha_fin) {
            $diasRestantes = max(0, Carbon::today()->diffInDays($usuario->fecha_fin, false));
            $horasRestantes = $diasRestantes * 8;
        }

        return view('perfil', compact('usuario', 'incidencias', 'llegadasTarde', 'horasRestantes'));
    }
}
