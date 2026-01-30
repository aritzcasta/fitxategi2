<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Fichaje;
use App\Models\Festivo;
use Illuminate\Support\Carbon;

class MarkNoEntryByTwoAsAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fichaje:mark-no-entry-by-two {--date= : Fecha a procesar (Y-m-d), por defecto hoy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca como ausencia sin justificar (estado=2) a los usuarios que no han fichado entrada antes de las 14:00.';

    public function handle()
    {
        $dateOption = $this->option('date');
        $date = $dateOption ? Carbon::parse($dateOption)->startOfDay() : Carbon::today()->startOfDay();

        // No laborables
        $festivo = Festivo::query()->whereDate('fecha', $date)->first();
        if ($date->isWeekend() || $festivo) {
            $this->info('Día no laborable (' . $date->toDateString() . '). No se marcan ausencias.');
            return 0;
        }

        $this->info('Marcando ausencias por no fichar antes de las 14:00 para fecha: ' . $date->toDateString());

        $users = Usuario::query()->where('activo', true)->get();
        $created = 0;
        $updated = 0;

        foreach ($users as $user) {
            $fichaje = Fichaje::where('id_usuario', $user->id)
                ->whereDate('fecha', $date)
                ->first();

            if (! $fichaje) {
                Fichaje::create([
                    'id_usuario' => $user->id,
                    'fecha' => $date,
                    'fecha_original' => $date,
                    'estado' => 2,
                    'justificado' => false,
                ]);
                $created++;

                try {
                    $user->increment('ausencias_sin_justificar');
                } catch (\Throwable $e) {
                    // ignore
                }

                continue;
            }

            // Si ya hay entrada, no es ausencia
            if (! empty($fichaje->hora_entrada)) {
                continue;
            }

            // Si ya estaba como ausente, no duplicar
            if ((int) $fichaje->estado === 2) {
                continue;
            }

            $fichaje->estado = 2;
            $fichaje->justificado = false;
            $fichaje->save();
            $updated++;

            try {
                $user->increment('ausencias_sin_justificar');
            } catch (\Throwable $e) {
                // ignore
            }
        }

        $this->info("Ausencias creadas: {$created}, actualizadas: {$updated}");

        return 0;
    }
}
