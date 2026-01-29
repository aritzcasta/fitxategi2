<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use App\Models\Incidencia;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    public function updatePassword(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $usuario = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($request->current_password, $usuario->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $usuario->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Contraseña actualizada correctamente.');
    }
}
