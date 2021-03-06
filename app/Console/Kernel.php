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
        \App\Console\Commands\TareasProximasCommand::class,
        \App\Console\Commands\VisitasProximasCommand::class,
        \App\Console\Commands\MetasDiaSiguienteCommand::class,
        \App\Console\Commands\LlenaVisitaTerminadaCommand::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('tareas:proximas')
                 ->everyMinute();
        $schedule->command('visitas:proximas')
                ->everyFifteenMinutes();
        $schedule->command('metas:siguiente')
                ->dailyAt('1:00');
        $schedule->command('visita:llenar')
                 ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
