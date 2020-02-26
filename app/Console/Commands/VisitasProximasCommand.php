<?php

namespace App\Console\Commands;

use App\Notifications\VisitaProximaNotification;
use Illuminate\Console\Command;
use App\Models\Visita;
use Carbon\Carbon;

class VisitasProximasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visitas:proximas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $visitas = Visita::whereBetween('fecha_inicio', [Carbon::now()->toDateTimeString(),Carbon::now()->addMinutes(15)->toDateTimeString()])->whereIn('estado_visita_id', [1,2,3,4])->get();
        foreach ($visitas as $visita) {
            $visita->vendedor->notify(new VisitaProximaNotification($visita->id));
        }
    }
}
