<?php

namespace App\Console\Commands;

use App\Notifications\LlenaVisitaNotification;
use Illuminate\Console\Command;
use App\Models\Visita;
use Carbon\Carbon;

class LlenaVisitaTerminadaCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visita:llenar';

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
        $visitas = Visita::whereBetween('fecha_fin', [
                            Carbon::now()->subMinutes(180)->toDateTimeString(),
                            Carbon::now()->subMinutes(120)->toDateTimeString()
                        ])
                        ->whereIn('estado_visita_id', [1,2,3,4,5])->get();
        
        foreach ($visitas as $visita) {
            if ($visita->detalles->count()==0) {
                $visita->vendedor->notify(new LlenaVisitaNotification($visita->id));
            }
        }
    }
}
