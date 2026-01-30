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

        $festivoHoy = Festivo::query()->whereDate('fecha', $hoy)->first();
        if ($hoy->isWeekend() || $festivoHoy) {
            $motivo = $hoy->isWeekend() ? 'fin de semana' : 'festivo';
            $texto = 'Hoy (' . $hoy->format('Y-m-d') . ') es ' . $motivo . '. No se puede fichar.';
            if ($festivoHoy && !empty($festivoHoy->nombre)) {
                $texto .= ' ' . $festivoHoy->nombre;
            }
            return back()->with(['status' => $texto, 'error' => true]);
        }

        $codigoIngresado = $request->input('codigo');
        $codigoValido = RegistroCodigo::where('codigo', $codigoIngresado)
            ->where('expires_at', '>=', Carbon::now())
            ->exists();

        if (! $codigoValido) {
            return back()->with(['status' => 'El código no es válido o ha caducado.', 'error' => true]);
        }

        // Regla: si no ficha antes de las 14:00, cuenta como falta (ausencia) y no se permite registrar entrada
        $limiteEntrada = Carbon::today()->setTime(14, 0, 0);
        if (Carbon::now()->greaterThanOrEqualTo($limiteEntrada)) {
            $fichaje = Fichaje::firstOrCreate(
                ['id_usuario' => $usuario->id, 'fecha' => $hoy],
                ['fecha_original' => $hoy]
            );

            if (! empty($fichaje->hora_entrada)) {
                return back()->with('status', 'Ya has registrado la entrada hoy.');
            }

            $wasAlreadyAbsent = ((int) ($fichaje->estado ?? 0) === 2);
            if (! $wasAlreadyAbsent) {
                $fichaje->estado = 2;
                $fichaje->justificado = false;
                $fichaje->save();

                try {
                    $usuario->increment('ausencias_sin_justificar');
                } catch (\Throwable $e) {
                }
            }

            return back()->with([
                'status' => 'Has superado las 14:00. Hoy cuenta como falta y no se puede registrar la entrada. Puedes enviar una justificación.',
                'error' => true,
            ]);
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

        // Determinar si llegó a tiempo o tarde
        $estado = 0; // 0 = a tiempo, 1 = tarde
        $horaInicio = null;
        if (! empty($usuario->horario) && preg_match('/^(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})$/', $usuario->horario, $matches)) {
            $horaInicio = Carbon::today()->setTimeFromTimeString($matches[1]);
        }
        if (! $horaInicio) {
            $horaInicio = Carbon::today()->setTime(8, 0, 0);
        }

        $limiteTarde = $horaInicio->copy()->addMinutes(5); // 08:05 si el inicio es 08:00
        $horaEntradaActual = Carbon::now();
        if ($horaEntradaActual->greaterThan($limiteTarde)) {
            $estado = 1;
        }

        $fichaje->estado = $estado;
        $fichaje->save();

        // Incrementar contador correspondiente según el estado
        try {
            if ($estado === 0) {
                $usuario->increment('llegadas_a_tiempo');
            } elseif ($estado === 1) {
                $usuario->increment('llegadas_tarde');
            }
        } catch (\Throwable $e) {
        }

        if ($wasCreated) {
            try {
                $usuario->increment('veces_registradas');
            } catch (\Throwable $e) {
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

        $festivoHoy = Festivo::query()->whereDate('fecha', $hoy)->first();
        if ($hoy->isWeekend() || $festivoHoy) {
            $motivo = $hoy->isWeekend() ? 'fin de semana' : 'festivo';
            $texto = 'Hoy (' . $hoy->format('Y-m-d') . ') es ' . $motivo . '. No se puede fichar.';
            if ($festivoHoy && !empty($festivoHoy->nombre)) {
                $texto .= ' ' . $festivoHoy->nombre;
            }
            return back()->with(['status' => $texto, 'error' => true]);
        }

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

        $festivo = Festivo::query()->whereDate('fecha', $fecha)->first();
        if ($fecha->isWeekend() || $festivo) {
            $motivo = $fecha->isWeekend() ? 'fin de semana' : 'festivo';
            $texto = 'La fecha seleccionada (' . $fecha->format('Y-m-d') . ') es ' . $motivo . '. No se puede justificar ausencia ese día.';
            if ($festivo && !empty($festivo->nombre)) {
                $texto .= ' ' . $festivo->nombre;
            }
            return back()->with(['status' => $texto, 'error' => true]);
        }

        $fichaje = Fichaje::firstOrCreate(
            ['id_usuario' => $usuario->id, 'fecha' => $fecha],
            ['fecha_original' => $fecha]
        );

        $wasAlreadyJustificado = (bool) $fichaje->justificado;

        // Si no hay entrada, esto es una ausencia (estado=2)
        if (empty($fichaje->hora_entrada) && (int) $fichaje->estado !== 2) {
            $fichaje->estado = 2;
        }

        $fichaje->justificado = true; // tiene justificación asociada (pendiente de validar)
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

        // Los contadores de ausencias se ajustan cuando el admin aprueba/rechaza.
        // Aquí solo marcamos como pendiente.

        if ($wasAlreadyJustificado) {
            return back()->with('status', 'Justificación actualizada. Quedará pendiente de revisión.');
        }

        return back()->with('status', 'Justificación enviada. Quedará pendiente de revisión.');
    }
}
