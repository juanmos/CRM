<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use App\Models\Visita;

class ReporteVisitasExport implements FromView
{
    private $fecha_inicio=null;
    private $fecha_fin=null;
    private $estado_id=null;
    private $cliente=null;
    private $usuario_id=null;

    public function __construct($fecha_inicio,$fecha_fin,$estado_id,$cliente,$usuario_id)
    {
        $this->fecha_inicio=$fecha_inicio;
        $this->fecha_fin=$fecha_fin;
        $this->estado_id=$estado_id;
        $this->cliente=$cliente;
        $this->usuario_id=$usuario_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): view
    {
        $visitas = Visita::whereBetween('fecha_inicio',array($this->fecha_inicio.' 00:00:00' ,$this->fecha_fin.' 23:59:59' ));
        if($this->estado_id > 0){
            $visitas = $visitas->where('estado_visita_id',$this->estado_id);
        }
        // $cliente=
        if($this->cliente!=null){
            $visitas = $visitas->whereHas('cliente',function($query) {
                $query->where('nombre','like','%'.$this->cliente.'%');
            });
        }         
        if($this->usuario_id > 0){
            $visitas = $visitas->where('usuario_id',$this->usuario_id);
        }  
        $visitas= $visitas->with(['vendedor','cliente','tipoVisita','contacto'])
                ->orderBy('fecha_inicio','desc')->get();   
        return view('exports.visita',compact('visitas'));
    }

    
}
