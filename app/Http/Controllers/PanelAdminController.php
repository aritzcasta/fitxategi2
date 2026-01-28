<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Fichaje;
use Illuminate\Support\Carbon;
use App\Models\Empresa;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EmpresaExport;
use Illuminate\Support\Str;

class PanelAdminController extends Controller
{
    public function index(){
        return view('admin.panel');
    }

    public function justificaciones(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $justificaciones = Fichaje::query()
            ->with(['usuario:id,nombre,email'])
            ->where('justificado', true)
            ->whereNotNull('justificacion')
            ->when($desde, function ($query, $desde) {
                $query->whereDate('fecha', '>=', Carbon::parse($desde)->startOfDay());
            })
            ->when($hasta, function ($query, $hasta) {
                $query->whereDate('fecha', '<=', Carbon::parse($hasta)->endOfDay());
            })
            ->orderByDesc('fecha')
            ->paginate(20)
            ->withQueryString();

        return view('admin.justificaciones', [
            'justificaciones' => $justificaciones,
            'desde' => $desde,
            'hasta' => $hasta,
        ]);
    }

    public function usuarios()
    {
        $hoy = Carbon::today();

        $q = request('q');

        $users = Usuario::with('rol')
            ->whereHas('rol', function ($r) {
                $r->where('nombre', 'usuario');
            })
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
        $empresa = Empresa::findOrFail($id);

        // Obtener usuarios asociados que NO sean administradores (incluye usuarios sin rol)
        $usuarios = $empresa->usuarios()
            ->whereDoesntHave('rol', function ($q) {
                $q->where('nombre', 'admin');
            })
            ->withCount('fichajes')
            ->with(['fichajes' => function ($q) {
                $q->latest('fecha')->limit(1);
            }])
            ->get();

        return view('admin.empresa', ['empresa' => $empresa, 'usuarios' => $usuarios]);
    }

    public function empresaExportExcel($id)
    {
        $empresa = Empresa::with(['usuarios' => function ($q) {
            $q->whereHas('rol', function($r) { $r->where('nombre', 'usuario'); })
              ->withCount('fichajes')
              ->with(['fichajes' => function ($q2) {
                  $q2->latest('fecha')->limit(1);
              }]);
        }])->findOrFail($id);

        $filename = 'empresa_'.Str::slug($empresa->nombre ?: $empresa->id).'.xlsx';
        $usersParam = request('users');
        return Excel::download(new EmpresaExport($empresa, $usersParam), $filename);
    }

    public function empresaExportPdf($id)
    {
        $empresa = Empresa::with(['usuarios' => function ($q) {
            $q->whereHas('rol', function($r) { $r->where('nombre', 'usuario'); })
              ->withCount('fichajes')
              ->with(['fichajes' => function ($q2) {
                  $q2->latest('fecha')->limit(1);
              }]);
        }])->findOrFail($id);

        $usersParam = request('users');
        if ($usersParam) {
            // load specific users for PDF view
            $ids = array_filter(array_map('intval', explode(',', (string)$usersParam)));
            $usuarios = \App\Models\Usuario::whereIn('id', $ids)->where('empresa_id', $empresa->id)
                ->whereHas('rol', function($r) { $r->where('nombre', 'usuario'); })
                ->withCount('fichajes')
                ->with(['fichajes' => function ($q2) { $q2->latest('fecha')->limit(1); }])
                ->get();
            $pdf = Pdf::loadView('admin.empresa_export_pdf', ['empresa' => $empresa, 'usuarios' => $usuarios]);
        } else {
            $pdf = Pdf::loadView('admin.empresa_export_pdf', ['empresa' => $empresa]);
        }

        $filename = 'empresa_'.Str::slug($empresa->nombre ?: $empresa->id).'.pdf';
        return $pdf->download($filename);
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
}
