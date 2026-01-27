<?php

namespace App\Http\Controllers;

use App\Models\Fichaje;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $usuario = Auth::user();
        $hoy = Carbon::today();

        $fichajeHoy = Fichaje::where('id_usuario', $usuario->id)
            ->whereDate('fecha', $hoy)
            ->first();

        $yaEntrada = $fichajeHoy && $fichajeHoy->hora_entrada;
        $yaSalida = $fichajeHoy && $fichajeHoy->hora_salida;

        $horaFin = null;
        $puedeSalida = true;

        if (! empty($usuario->horario)) {
            if (preg_match('/^(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})$/', $usuario->horario, $matches)) {
                $horaFin = Carbon::today()->setTimeFromTimeString($matches[2]);
                $puedeSalida = Carbon::now()->greaterThanOrEqualTo($horaFin);
            }
        }

        return view('home', compact('yaEntrada', 'yaSalida', 'puedeSalida', 'horaFin', 'fichajeHoy'));
    }
}
