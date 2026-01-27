<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Fichaje;
use Illuminate\Support\Carbon;

class MarkUnregisteredAsAbsent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fichaje:mark-absences {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marca como sin_justificar los días en que un usuario no registró fichaje (por defecto ayer).';

    public function handle()
    {
        $dateOption = $this->option('date');
        $date = $dateOption ? Carbon::parse($dateOption)->startOfDay() : Carbon::yesterday()->startOfDay();

        $this->info('Marcando ausencias para fecha: ' . $date->toDateString());

        $users = Usuario::all();
        $created = 0;
        $updated = 0;

        foreach ($users as $user) {
            // Buscar fichaje para la fecha
            $fichaje = Fichaje::where('id_usuario', $user->id)
                ->whereDate('fecha', $date)
                ->first();

            if (! $fichaje) {
                // Crear registro marcando ausencia sin justificar
                Fichaje::create([
                    'id_usuario' => $user->id,
                    'fecha' => $date,
                    'fecha_original' => $date,
                    'estado' => 'sin_justificar',
                    'justificado' => false,
                ]);
                $created++;
                // Incrementar contador de faltas sin justificar en usuario
                try {
                    $user->increment('faltas_sin_justificar');
                } catch (\Throwable $e) {
                    // ignore
                }
            } else {
                // Si existe pero no tiene entrada y no está justificado, marcar estado
                if (empty($fichaje->hora_entrada) && ! $fichaje->justificado && $fichaje->estado !== 'sin_justificar') {
                    $previousEstado = $fichaje->estado;
                    $fichaje->estado = 'sin_justificar';
                    $fichaje->save();
                    $updated++;
                    // Si antes no era sin_justificar, incrementamos contador
                    try {
                        $user->increment('faltas_sin_justificar');
                    } catch (\Throwable $e) {
                        // ignore
                    }
                }
            }
        }

        $this->info("Ausencias creadas: {$created}, actualizadas: {$updated}");

        return 0;
    }
}
