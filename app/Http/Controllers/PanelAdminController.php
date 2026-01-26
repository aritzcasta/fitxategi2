<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Fichaje;
use Illuminate\Support\Carbon;
use App\Models\Empresa;

class PanelAdminController extends Controller
{
    public function index(){
        return view('admin.panel');
    }

    public function usuarios()
    {
        $hoy = Carbon::today();

        $users = Usuario::with('rol')->get()->map(function ($user) use ($hoy) {
            $fichajeHoy = Fichaje::where('id_usuario', $user->id)
                ->whereDate('fecha', $hoy)
                ->first();

            $status = 'red'; // default: no registrado

            if ($fichajeHoy && $fichajeHoy->hora_entrada) {
                // hora_entrada format assumed H:i:s or H:i
                $entrada = Carbon::createFromFormat('H:i:s', $fichajeHoy->hora_entrada, config('app.timezone'));
                if (! $entrada) {
                    $entrada = Carbon::createFromFormat('H:i', $fichajeHoy->hora_entrada, config('app.timezone'));
                }

                // normalize to today
                $entrada->setDate($hoy->year, $hoy->month, $hoy->day);

                $inicio = Carbon::today()->setTime(8, 0, 0);
                $limite = Carbon::today()->setTime(8, 5, 0);

                if ($entrada->betweenIncluded($inicio, $limite)) {
                    $status = 'green';
                } else {
                    $status = 'yellow';
                }
            }

            $user->fichaje_hoy = $fichajeHoy;
            $user->status = $status;

            return $user;
        });

        return view('admin.usuarios', ['users' => $users]);
    }

    public function empresas()
    {
        $empresas = Empresa::all();
        return view('admin.empresas', ['empresas' => $empresas]);
    }

    public function empresaShow($id)
    {
        $empresa = Empresa::with('usuarios.rol')->findOrFail($id);
        return view('admin.empresa', ['empresa' => $empresa]);
    }
}
