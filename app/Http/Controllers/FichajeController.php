<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use App\Models\RegistroCodigo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class FichajeController extends Controller
{
    public function entrada(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        $hoy = Carbon::today();

        $codigoIngresado = $request->input('codigo');
        $codigoValido = RegistroCodigo::where('codigo', $codigoIngresado)
            ->where('expires_at', '>=', Carbon::now())
            ->exists();

        if (! $codigoValido) {
            return back()->with(['status' => 'El código no es válido o ha caducado.', 'error' => true]);
        }

        $fichaje = Fichaje::firstOrCreate(
            ['id_usuario' => $usuario->id, 'fecha' => $hoy],
            ['fecha_original' => $hoy]
        );
        $wasCreated = $fichaje->wasRecentlyCreated;

        if ($fichaje->hora_entrada) {
            return back()->with('status', 'Ya has registrado la entrada hoy.');
        }

        $fichaje->hora_entrada = Carbon::now()->format('H:i:s');
        $fichaje->save();

        if ($wasCreated) {
            // Increment the counter of times registered for the user
            try {
                $usuario->increment('veces_registradas');
            } catch (\Throwable $e) {
                // don't break the flow if increment fails; log could be added
            }
        }

        return back()->with('status', 'Entrada registrada correctamente.');
    }

    public function salida(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        $hoy = Carbon::today();

        $codigoIngresado = $request->input('codigo');
        $codigoValido = RegistroCodigo::where('codigo', $codigoIngresado)
            ->where('expires_at', '>=', Carbon::now())
            ->exists();

        if (! $codigoValido) {
            return back()->with(['status' => 'El código no es válido o ha caducado.', 'error' => true]);
        }

        $fichaje = Fichaje::where('id_usuario', $usuario->id)
            ->whereDate('fecha', $hoy)
            ->first();

        if (! $fichaje || ! $fichaje->hora_entrada) {
            return back()->with(['status' => 'Primero debes registrar la entrada.', 'error' => true]);
        }

        if ($fichaje->hora_salida) {
            return back()->with(['status' => 'Ya has registrado la salida hoy.', 'error' => true]);
        }

        if (! empty($usuario->horario)) {
            if (preg_match('/^(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})$/', $usuario->horario, $matches)) {
                $horaFin = Carbon::today()->setTimeFromTimeString($matches[2]);
                if (Carbon::now()->lt($horaFin)) {
                    return back()->with(['status' => 'Aún no ha terminado tu horario. Puedes fichar la salida a partir de las ' . $matches[2] . '.', 'error' => true]);
                }
            }
        }

        $fichaje->hora_salida = Carbon::now()->format('H:i:s');
        $fichaje->save();

        return back()->with('status', 'Salida registrada correctamente.');
    }
}
