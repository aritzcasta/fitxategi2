<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Fichaje;
use Illuminate\Support\Carbon;

class RecalculateLlegadasATiempo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recalculate:llegadas-a-tiempo {--user=* : Recalculate only for these user ids}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalcula estado y contadores de llegadas (a tiempo/tarde) según horario del usuario y tolerancia (5 min)';

    public function handle()
    {
        $userIds = $this->option('user');

        $query = Usuario::query();
        if (!empty($userIds)) {
            $query->whereIn('id', $userIds);
        }

        $usuarios = $query->get();
        $this->info('Usuarios a procesar: ' . $usuarios->count());

        $updatedUsers = 0;
        $updatedFichajes = 0;

        foreach ($usuarios as $usuario) {
            $matches = [];
            $hasHorario = ! empty($usuario->horario) && preg_match('/^(\d{1,2}:\d{2})\s*-\s*(\d{1,2}:\d{2})$/', $usuario->horario, $matches);
            $horaInicioStr = $hasHorario ? $matches[1] : '08:00';

            $fichajes = Fichaje::where('id_usuario', $usuario->id)
                ->whereNotNull('hora_entrada')
                ->where('estado', '!=', 2)
                ->get(['id', 'fecha', 'hora_entrada', 'estado']);

            foreach ($fichajes as $fichaje) {
                $dia = Carbon::parse($fichaje->fecha)->startOfDay();
                $horaInicio = $dia->copy()->setTimeFromTimeString($horaInicioStr);
                $limiteTarde = $horaInicio->copy()->addMinutes(5);
                $horaEntrada = $dia->copy()->setTimeFromTimeString($fichaje->hora_entrada);

                $newEstado = $horaEntrada->greaterThan($limiteTarde) ? 1 : 0;
                if ((int) $fichaje->estado !== $newEstado) {
                    $fichaje->estado = $newEstado;
                    $fichaje->save();
                    $updatedFichajes++;
                }
            }

            $newATiempo = Fichaje::where('id_usuario', $usuario->id)
                ->where('estado', 0)
                ->whereNotNull('hora_entrada')
                ->count();
            $newTarde = Fichaje::where('id_usuario', $usuario->id)
                ->where('estado', 1)
                ->whereNotNull('hora_entrada')
                ->count();

            $oldATiempo = $usuario->llegadas_a_tiempo ?? 0;
            $oldTarde = $usuario->llegadas_tarde ?? 0;

            if ($oldATiempo != $newATiempo || $oldTarde != $newTarde) {
                $usuario->llegadas_a_tiempo = $newATiempo;
                $usuario->llegadas_tarde = $newTarde;
                $usuario->save();
                $this->line("Usuario {$usuario->id} ({$usuario->nombre}): a_tiempo {$oldATiempo} -> {$newATiempo}, tarde {$oldTarde} -> {$newTarde}");
                $updatedUsers++;
            }
        }

        $this->info("Fichajes con estado actualizado: {$updatedFichajes}");
        $this->info("Usuarios con contadores actualizados: {$updatedUsers}");

        return 0;
    }
}
