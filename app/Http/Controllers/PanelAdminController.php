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

        $q = request('q');

        $users = Usuario::with('rol')
            ->when($q, function ($query, $q) {
                $query->where(function($sub) use ($q) {
                    $sub->where('nombre', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%");
                });
            })
            ->get()
            ->map(function ($user) use ($hoy) {
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

        return view('admin.usuarios', ['users' => $users, 'q' => $q]);
    }

    public function empresas()
    {
        $q = request('q');

        $empresas = Empresa::when($q, function ($query, $q) {
            $query->where('nombre', 'like', "%{$q}%");
        })->get();

        return view('admin.empresas', ['empresas' => $empresas, 'q' => $q]);
    }

    public function empresaShow($id)
    {
        $empresa = Empresa::with('usuarios.rol')->findOrFail($id);
        return view('admin.empresa', ['empresa' => $empresa]);
    }

    public function usuarioEdit($id)
    {
        $user = Usuario::findOrFail($id);
        return view('admin.usuario_edit', ['user' => $user]);
    }

    public function usuarioUpdate(Request $request, $id)
    {
        $user = Usuario::findOrFail($id);

        $data = $request->validate([
            'email' => 'required|email|unique:usuario,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'fecha_fin' => 'nullable|date',
        ]);

        $user->email = $data['email'];

        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->fecha_fin = $data['fecha_fin'] ?? null;
        $user->save();

        return redirect()->route('admin.usuarios')->with('status', 'Usuario actualizado correctamente.');
    }
    public function usuarioDestroy(Request $request, $id)
    {
        //soft delete
        $user = Usuario::findOrFail($id);

        $user->delete();
        return redirect()->route('admin.usuarios')->with('status', 'Usuario eliminado correctamente');
    }
     public function usuarioKill(Request $request, $id)
    {
        //soft delete
        $user = Usuario::findOrFail($id);

        $user->forceDelete();
        return redirect()->route('admin.usuarios')->with('status', 'Usuario eliminado correctamente');
    }
}
