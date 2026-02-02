<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Fichaje;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Empresa;
use App\Models\Festivo;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\EmpresaExport;
use Illuminate\Support\Str;

class PanelAdminController extends Controller
{
    private function recalculateAusenciasCounters(Usuario $usuario): void
    {
        $justificacionesAprobadas = Fichaje::query()
            ->where('id_usuario', $usuario->id)
            ->whereNotNull('justificacion')
            ->where('justificacion_estado', 'approved')
            ->count();

        $justificacionesRechazadas = Fichaje::query()
            ->where('id_usuario', $usuario->id)
            ->whereNotNull('justificacion')
            ->where('justificacion_estado', 'rejected')
            ->count();

        $justificadas = Fichaje::query()
            ->where('id_usuario', $usuario->id)
            ->where('estado', 2)
            ->where('justificacion_estado', 'approved')
            ->count();

        $sinJustificar = Fichaje::query()
            ->where('id_usuario', $usuario->id)
            ->where('estado', 2)
            ->where(function ($q) {
                $q->whereNull('justificacion_estado')
                    ->orWhere('justificacion_estado', 'pending')
                    ->orWhere('justificacion_estado', 'rejected');
            })
            ->count();

        $usuario->ausencias_justificadas = $justificadas;
        $usuario->ausencias_sin_justificar = $sinJustificar;
        $usuario->faltas_justificadas = $justificacionesAprobadas;
        $usuario->faltas_sin_justificar = $justificacionesRechazadas;
        $usuario->save();
    }

    public function index(){
        return view('admin.panel');
    }

    public function justificaciones(Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');
        $estado = $request->query('estado');
        $buscar = $request->query('buscar');

        $justificaciones = Fichaje::query()
            ->with(['usuario:id,nombre,email'])
            ->where('justificado', true)
            ->whereNotNull('justificacion')
            ->when($buscar, function ($query, $buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('justificacion', 'like', "%{$buscar}%")
                      ->orWhereHas('usuario', function ($subQ) use ($buscar) {
                          $subQ->where('nombre', 'like', "%{$buscar}%")
                               ->orWhere('email', 'like', "%{$buscar}%");
                      });
                });
            })
            ->when($estado, function ($query, $estado) {
                // Normalizar estados
                $estado = strtolower(trim((string) $estado));
                if ($estado === 'all' || $estado === '') {
                    return;
                }

                if ($estado === 'pending' || $estado === 'pendiente') {
                    $query->where(function ($q) {
                        $q->whereNull('justificacion_estado')
                            ->orWhere('justificacion_estado', 'pending');
                    });
                    return;
                }

                if (in_array($estado, ['approved', 'aprobada', 'aprobado'], true)) {
                    $query->where('justificacion_estado', 'approved');
                    return;
                }

                if (in_array($estado, ['rejected', 'rechazada', 'rechazado'], true)) {
                    $query->where('justificacion_estado', 'rejected');
                    return;
                }
            })
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
            'estado' => $estado,
        ]);
    }

    public function justificacionesApprove($id)
    {
        $fichaje = Fichaje::query()->with('usuario')->findOrFail($id);

        if (empty($fichaje->justificacion)) {
            return redirect()->route('admin.justificaciones')->with('status', 'No hay justificación para validar.');
        }

        if (($fichaje->justificacion_estado ?? '') === 'approved') {
            return redirect()->route('admin.justificaciones')->with('status', 'Esta justificación ya estaba aprobada.');
        }

        // Si no hay entrada, esto es una ausencia
        if (empty($fichaje->hora_entrada) && (int) $fichaje->estado !== 2) {
            $fichaje->estado = 2;
        }

        $fichaje->justificacion_estado = 'approved';
        $fichaje->save();

        if ($fichaje->usuario) {
            $this->recalculateAusenciasCounters($fichaje->usuario);
        }

        return redirect()->route('admin.justificaciones')->with('status', 'Justificación aprobada.');
    }

    public function justificacionesReject($id)
    {
        $fichaje = Fichaje::query()->with('usuario')->findOrFail($id);

        if (empty($fichaje->justificacion)) {
            return redirect()->route('admin.justificaciones')->with('status', 'No hay justificación para rechazar.');
        }

        if (($fichaje->justificacion_estado ?? '') === 'rejected') {
            return redirect()->route('admin.justificaciones')->with('status', 'Esta justificación ya estaba rechazada.');
        }

        // Si no hay entrada, esto es una ausencia
        if (empty($fichaje->hora_entrada) && (int) $fichaje->estado !== 2) {
            $fichaje->estado = 2;
        }

        $fichaje->justificacion_estado = 'rejected';
        $fichaje->save();

        if ($fichaje->usuario) {
            $this->recalculateAusenciasCounters($fichaje->usuario);
        }

        return redirect()->route('admin.justificaciones')->with('status', 'Justificación rechazada.');
    }

    public function festivos()
    {
        $festivos = Festivo::query()->orderByDesc('fecha')->get();
        return view('admin.festivos', ['festivos' => $festivos]);
    }

    public function festivosStore(Request $request)
    {
        // Soportar alta múltiple: fechas[] (varios inputs) o compatibilidad con fecha única
        $data = $request->validate([
            'fechas' => 'nullable|array',
            'fechas.*' => 'nullable|date',
            'fecha' => 'nullable|date',
            'desde' => 'nullable|date|required_with:hasta',
            'hasta' => 'nullable|date|required_with:desde|after_or_equal:desde',
            'nombre' => 'nullable|string|max:255',
        ]);

        $fechas = [];

        // 1) Rango desde/hasta (inclusive)
        if (!empty($data['desde']) && !empty($data['hasta'])) {
            $desde = Carbon::parse($data['desde'])->startOfDay();
            $hasta = Carbon::parse($data['hasta'])->startOfDay();

            // Límite defensivo para evitar altas masivas por error
            if ($desde->diffInDays($hasta) > 366) {
                return redirect()->route('admin.festivos')
                    ->with('status', 'El rango es demasiado grande (máx. 367 días).');
            }

            $period = CarbonPeriod::create($desde, $hasta);
            foreach ($period as $date) {
                $fechas[] = $date->toDateString();
            }
        }

        // 2) Fechas sueltas (varios inputs)
        if (empty($fechas) && !empty($data['fechas'])) {
            $fechas = array_values(array_filter($data['fechas'], function ($v) {
                return !is_null($v) && $v !== '';
            }));
        }

        // 3) Compatibilidad con una fecha única
        if (empty($fechas) && !empty($data['fecha'])) {
            $fechas = [$data['fecha']];
        }

        if (empty($fechas)) {
            return redirect()->route('admin.festivos')
                ->with('status', 'No se ha indicado ninguna fecha.');
        }

        $nombre = $data['nombre'] ?? null;
        $created = 0;
        $skipped = 0;

        foreach ($fechas as $fecha) {
            $dateString = Carbon::parse($fecha)->toDateString();
            $festivo = Festivo::firstOrCreate(
                ['fecha' => $dateString],
                ['nombre' => $nombre]
            );
            if ($festivo->wasRecentlyCreated) {
                $created++;
            } else {
                $skipped++;
            }
        }

        $msg = 'Festivos guardados. Creados: ' . $created;
        if ($skipped > 0) {
            $msg .= ' · Omitidos (ya existían): ' . $skipped;
        }

        return redirect()->route('admin.festivos')->with('status', $msg);
    }

    public function festivosDestroyMany(Request $request)
    {
        $data = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        $deleted = Festivo::query()->whereIn('id', $data['ids'])->delete();

        return redirect()->route('admin.festivos')->with('status', 'Festivos eliminados: ' . $deleted);
    }

    public function festivosDestroy($id)
    {
        $festivo = Festivo::findOrFail($id);
        $festivo->delete();

        return redirect()->route('admin.festivos')->with('status', 'Festivo eliminado correctamente.');
    }

    public function usuarios()
    {
        $hoy = Carbon::today();

        $buscar = request('buscar');

        $users = Usuario::with(['rol', 'empresa'])
            ->whereHas('rol', function ($r) {
                $r->where('nombre', 'usuario');
            })
            ->when($buscar, function ($query, $buscar) {
                $query->where(function($sub) use ($buscar) {
                    $sub->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%")
                        ->orWhereHas('empresa', function ($empQ) use ($buscar) {
                            $empQ->where('nombre', 'like', "%{$buscar}%");
                        });
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

        return view('admin.usuarios', ['users' => $users]);
    }

    public function empresas()
    {
        $buscar = request('buscar');

        $empresas = Empresa::when($buscar, function ($query, $buscar) {
            $query->where('nombre', 'like', "%{$buscar}%");
        })->get();

        return view('admin.empresas', ['empresas' => $empresas]);
    }

    public function empresaCreate()
    {
        return view('admin.empresa_create');
    }

    public function empresaStore(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255|unique:empresa,nombre',
        ]);

        $empresa = Empresa::create([
            'nombre' => $data['nombre'],
        ]);

        return redirect()->route('admin.empresas.show', $empresa->id)
            ->with('status', 'Empresa creada correctamente.');
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
