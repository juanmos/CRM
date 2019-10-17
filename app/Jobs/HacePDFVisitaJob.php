<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\EnviaClienteNotification;
use App\Models\Visita;
use Carbon\Carbon;
use Auth;
use File;
use App;
class HacePDFVisitaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $visita=Visita::find($this->id);
        $nombre_archivo=storage_path('app/public/pdf/'.Auth::user()->empresa_id.'/Visita-'.$visita->id.'-'.Carbon::parse($visita->fecha_inicio)->format('d-m-Y-H-i-s').'.pdf');
        if (file_exists( $nombre_archivo)){
            File::delete($nombre_archivo);
        }
        $view = view('visita.pdf',compact('visita'))->render(); 
        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($view);
        $visita->pdf='storage/pdf/'.Auth::user()->empresa_id.'/Visita-'.$visita->id.'-'.Carbon::parse($visita->fecha_inicio)->format('d-m-Y-H-i-s').'.pdf';
        $visita->save();
        $pdf->save($nombre_archivo);
        $visita->vendedor->notify(new EnviaClienteNotification($visita));
    }
}
