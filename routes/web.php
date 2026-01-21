<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Carbon;
use App\Models\Incidencia;
use App\Models\Fichaje;
use App\Models\RegistroCodigo;

Auth::routes();

function obtenerCodigoActual(): RegistroCodigo
{
    $codigo = RegistroCodigo::where('expires_at', '>=', Carbon::now())
        ->orderByDesc('expires_at')
        ->first();

    if (! $codigo) {
        $codigo = RegistroCodigo::create([
            'codigo' => (string) random_int(100000, 999999),
            'expires_at' => Carbon::now()->addSeconds(15),
        ]);
    }

    return $codigo;
}

Route::get('/codigo', function () {
    $codigo = obtenerCodigoActual();

    return view('codigo', ['codigo' => $codigo]);
})->name('codigo');

Route::get('/codigo/actual', function () {
    $codigo = obtenerCodigoActual();

    return response()->json([
        'codigo' => $codigo->codigo,
        'expires_at' => $codigo->expires_at->toIso8601String(),
    ]);
})->name('codigo.actual');

Route::middleware('session.auth')->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/perfil', function () {
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
    })->name('perfil');

    Route::post('/fichaje/entrada', function (\Illuminate\Http\Request $request) {
        $usuario = Auth::user();
        $hoy = Carbon::today();

        $codigoIngresado = $request->input('codigo');
        $codigoValido = RegistroCodigo::where('codigo', $codigoIngresado)
            ->where('expires_at', '>=', Carbon::now())
            ->exists();

        if (! $codigoValido) {
            return back()->with('status', 'El código no es válido o ha caducado.');
        }

        $fichaje = Fichaje::firstOrCreate(
            ['id_usuario' => $usuario->id, 'fecha' => $hoy],
            ['fecha_original' => $hoy]
        );

        if ($fichaje->hora_entrada) {
            return back()->with('status', 'Ya has registrado la entrada hoy.');
        }

        $fichaje->hora_entrada = Carbon::now()->format('H:i:s');
        $fichaje->save();

        return back()->with('status', 'Entrada registrada correctamente.');
    })->name('fichaje.entrada');

    Route::post('/fichaje/salida', function () {
        $usuario = Auth::user();
        $hoy = Carbon::today();

        $fichaje = Fichaje::where('id_usuario', $usuario->id)
            ->whereDate('fecha', $hoy)
            ->first();

        if (! $fichaje || ! $fichaje->hora_entrada) {
            return back()->with('status', 'Primero debes registrar la entrada.');
        }

        if ($fichaje->hora_salida) {
            return back()->with('status', 'Ya has registrado la salida hoy.');
        }

        if (! empty($usuario->horario)) {
            if (preg_match('/^(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})$/', $usuario->horario, $matches)) {
                $horaFin = Carbon::today()->setTimeFromTimeString($matches[2]);
                if (Carbon::now()->lt($horaFin)) {
                    return back()->with('status', 'Aún no ha terminado tu horario.');
                }
            }
        }

        $fichaje->hora_salida = Carbon::now()->format('H:i:s');
        $fichaje->save();

        return back()->with('status', 'Salida registrada correctamente.');
    })->name('fichaje.salida');
});
