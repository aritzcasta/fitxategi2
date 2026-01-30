<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\MarkUnregisteredAsAbsent::class,
        \App\Console\Commands\MarkNoEntryByTwoAsAbsent::class,
        \App\Console\Commands\RecalculateLlegadasATiempo::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Ejecuta diariamente a la 01:00 para marcar ausencias del día anterior
        $schedule->command('fichaje:mark-absences')->dailyAt('01:00');

        // Ejecuta diariamente a las 14:00 para marcar como ausencia si no hay entrada registrada
        $schedule->command('fichaje:mark-no-entry-by-two')->dailyAt('14:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        // load routes/console.php if exists
        if (file_exists(app_path('Console/routes.php'))) {
            $this->load(app_path('Console/routes.php'));
        }
    }
}
