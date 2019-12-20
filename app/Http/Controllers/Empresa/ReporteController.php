<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Notifications\CancelaVisitaNotification;
use App\Notifications\CambiosVisitaNotification;
use App\Notifications\EnviaClienteNotification;
use App\Notifications\NuevaVisitaNotification;
use App\Http\Controllers\Controller;
use App\Exports\ReporteVisitasExport;
use App\Jobs\HacePDFVisitaJob;
use App\Models\PlantillaDetalle;
use App\Models\Configuracion;
use App\Models\TipoVisita;
use App\Models\Empresa;
use App\Models\Tarea;
use App\Models\Visita;
use App\Models\EstadoVisita;
use App\Models\User;
use Carbon\Carbon;
use Excel;
use Auth;
use App;
use DB;

class ReporteController extends Controller
{
    public function visitas(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio') ?? now()->startOfMonth()->toDateString();
        $fecha_fin = $request->get('fecha_fin') ?? now()->toDateString();
        $estado_id=$request->get('estado_id') ?? 0;
        $cliente= $request->get('cliente') ?? '';
        $usuario_id = $request->get('usuario_id') ?? '';
            
        if(Auth::user()->hasRole('JefeVentas')){
            $usuarios = ['0'=>'Todos'] + User::where('user_id',Auth::user()->id)->orWhere('id',Auth::user()->id)->orderBy('nombre')->get()->pluck('full_name',"id")->toArray();
        }else{
            $usuarios = ['0'=>'Todos'] + User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->get()->pluck('full_name',"id")->toArray();
        }

        $estados = ['0'=>'Todos'] + EstadoVisita::get()->pluck('estado','id')->toArray();
        $visitas = $this->_filtrarData($fecha_inicio,$fecha_fin,$estado_id,$cliente);
        
        return view('reporte.visitas',compact('visitas','fecha_inicio','fecha_fin','estados','estado_id','cliente','usuarios','usuario_id'));
    }

    public function filtrar(Request $request)
    {
        $request->validate([
            'fecha_inicio'=>'required',
            'fecha_fin'=>'required',
        ]);
        $fecha_inicio = $request->get('fecha_inicio');
        $fecha_fin = $request->get('fecha_fin');
        $estado_id = $request->get('estado_id');
        $cliente = $request->get('cliente');
        $usuario_id = $request->get('usuario_id');
        $estados = ['0'=>'Todos'] + EstadoVisita::get()->pluck('estado','id')->toArray();
        $visitas = $this->_filtrarData($fecha_inicio,$fecha_fin,$estado_id,$cliente,$usuario_id);
        if(Auth::user()->hasRole('JefeVentas')){
            $usuarios = ['0'=>'Todos'] + User::where('user_id',Auth::user()->id)->orWhere('id',Auth::user()->id)->orderBy('nombre')->get()->pluck('full_name',"id")->toArray();
        }else{
            $usuarios = ['0'=>'Todos'] + User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->get()->pluck('full_name',"id")->toArray();
        }
        return view('reporte.visitas',compact('visitas','fecha_inicio','fecha_fin','estados','estado_id','cliente','usuarios','usuario_id'));
    }

    public function exportar(Request $request)
    {
        $request->validate([
            'fecha_inicio'=>'required',
            'fecha_fin'=>'required',
        ]);
        $fecha_inicio = $request->get('fecha_inicio');
        $fecha_fin = $request->get('fecha_fin');
        $estado_id = $request->get('estado_id');
        $cliente = $request->get('cliente');
        $usuario_id = $request->get('usuario_id');
        return Excel::download(new ReporteVisitasExport($fecha_inicio,$fecha_fin,$estado_id,$cliente,$usuario_id),'Visitas.xlsx');
        
    }

    private function _filtrarData($fecha_inicio,$fecha_fin,$estado_id,$cliente,$usuario_id){
        $visitas = Visita::whereBetween('fecha_inicio',array($fecha_inicio.' 00:00:00' ,$fecha_fin.' 23:59:59' ));
        if($estado_id > 0){
            $visitas = $visitas->where('estado_visita_id',$estado_id);
        }
        if($cliente!=null){
            $visitas = $visitas->whereHas('cliente',function($query) use($cliente){
                $query->where('nombre','like','%'.$cliente.'%');
            });
        }  
        if($usuario_id > 0){
            $visitas = $visitas->where('usuario_id',$usuario_id);
        }        
        return $visitas->with(['vendedor','cliente'])
                ->orderBy('fecha_inicio','desc')->paginate(50);   
    }
}
