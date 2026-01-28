<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use App\Models\Festivo;
use App\Models\RegistroCodigo;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class FichajeController extends Controller
{
    public function entrada(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        if (! $usuario instanceof Usuario) {
            abort(403, 'Acceso no autorizado.');
        }
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

        $manana = Carbon::today()->addDay();
        $festivoManana = Festivo::query()->whereDate('fecha', $manana)->first();

        $flash = ['status' => 'Entrada registrada correctamente.'];
        if ($festivoManana) {
            $texto = 'Aviso: mañana (' . $manana->format('Y-m-d') . ') es festivo.';
            if (!empty($festivoManana->nombre)) {
                $texto .= ' ' . $festivoManana->nombre;
            }
            $flash['warning'] = $texto;
        }

        return back()->with($flash);
    }

    public function salida(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        if (! $usuario instanceof Usuario) {
            abort(403, 'Acceso no autorizado.');
        }
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

        $manana = Carbon::today()->addDay();
        $festivoManana = Festivo::query()->whereDate('fecha', $manana)->first();

        $flash = ['status' => 'Salida registrada correctamente.'];
        if ($festivoManana) {
            $texto = 'Aviso: mañana (' . $manana->format('Y-m-d') . ') es festivo.';
            if (!empty($festivoManana->nombre)) {
                $texto .= ' ' . $festivoManana->nombre;
            }
            $flash['warning'] = $texto;
        }

        return back()->with($flash);
    }

    public function justificar(Request $request): RedirectResponse
    {
        $usuario = Auth::user();
        if (! $usuario instanceof Usuario) {
            abort(403, 'Acceso no autorizado.');
        }
        $hoy = Carbon::today();

        $data = $request->validate([
            'descripcion' => 'required|string|max:2000',
            'foto' => 'nullable|image|max:4096',
            'fecha' => 'nullable|date',
        ]);

        $fecha = isset($data['fecha']) ? Carbon::parse($data['fecha'])->startOfDay() : $hoy;

        $fichaje = Fichaje::firstOrCreate(
            ['id_usuario' => $usuario->id, 'fecha' => $fecha],
            ['fecha_original' => $fecha]
        );

        // Estado previo para ajustar contadores
        $wasAlreadyJustificado = (bool) $fichaje->justificado;
        $wasSinJustificar = ($fichaje->estado === 'sin_justificar');

        $fichaje->justificado = true;
        $fichaje->justificacion = $data['descripcion'];
        $fichaje->justificacion_estado = 'pending';

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');

            $dir = public_path('imagenes/justificacion');
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }

            $filename = Str::random(40) . '.' . $foto->getClientOriginalExtension();
            $foto->move($dir, $filename);

            // Guardamos la ruta relativa desde public para usar en vistas: "imagenes/justificacion/xxx.jpg"
            $fichaje->justificacion_foto = 'imagenes/justificacion/' . $filename;
        }

        $fichaje->save();

        // Si antes estuvo marcado como sin_justificar, decrementamos el contador de faltas sin justificar
        if ($wasSinJustificar) {
            try {
                if ($usuario->faltas_sin_justificar > 0) {
                    $usuario->decrement('faltas_sin_justificar');
                }
            } catch (\Throwable $e) {
                // ignore
            }
        }

        // Incrementar contador de faltas justificadas si antes no estaba justificado
        if (! $wasAlreadyJustificado) {
            try {
                $usuario->increment('faltas_justificadas');
            } catch (\Throwable $e) {
                // no bloquear el flujo si falla
            }
        }

        return back()->with('status', 'Justificación enviada. Quedará pendiente de revisión.');
    }
}
