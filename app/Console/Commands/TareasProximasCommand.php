<?php

namespace App\Console\Commands;

use App\Notifications\TareaProximaNotification;
use Illuminate\Console\Command;
use App\Models\Tarea;
use Carbon\Carbon;

class TareasProximasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tareas:proximas';

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
        $tareas = Tarea::whereBetween('fecha_notificacion',[Carbon::now()->toDateTimeString(),Carbon::now()->addMinutes(1)->toDateTimeString()])->where('realizado',0)->get();
        foreach($tareas as $tarea){
            $tarea->usuario->notify(new TareaProximaNotification($tarea->id));
        }
    }
}
