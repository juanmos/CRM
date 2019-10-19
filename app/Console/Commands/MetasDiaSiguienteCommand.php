<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Objetivo;
use Carbon\Carbon;
class MetasDiaSiguienteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'metas:siguiente';

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
        $fecha=Carbon::now()->toDateString();
        $metas = Objetivo::where('porcentaje','<',100)->where('fecha',Carbon::now()->subDays(1)->toDateString())->get();
        foreach($metas as $meta){
            $newMeta = $meta->replicate();
            $newMeta->fecha=$fecha;
            $newMeta->save();
        }
    }
}
