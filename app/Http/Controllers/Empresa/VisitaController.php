<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PlantillaDetalle;
use App\Models\Configuracion;
use App\Models\TipoVisita;
use App\Models\Empresa;
use App\Models\Tarea;
use App\Models\Visita;
use App\Models\EstadoVisita;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$usuario_id=null)
    {
        // $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        // if($usuario_id==null){
        //     $usuario_id=$usuarios->first()->id;
        // }

        // if($usuario_id==null){
        //     $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        //     $usuario_id=$usuarios->first()->id;
        // }else
        //$usuario_id=Auth::user()->id;
        if(Auth::user()->hasRole('Administrador')){
            $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        }elseif(Auth::user()->hasRole('JefeVentas')){
            $usuarios = User::where('user_id',Auth::user()->id)->orWhere('id',Auth::user()->id)->orderBy('nombre')->paginate(50);
        }else{
            $usuarios = User::where('id',$usuario_id)->orderBy('nombre')->paginate(50);
        }
        $tiposVisita = TipoVisita::where('empresa_id',0)->orWhere('empresa_id',Auth::user()->empresa_id)->orderBy('tipo')->get()->pluck('tipo','id');
        $tiempoVisita=['10'=>'10 minutos','20'=>'20 minutos','30'=>'30 minutos','45'=>'45 minutos','60'=>'1 hora','90'=>'1 hora y 30 minutos','120'=>'2 horas','180'=>'3 horas','240'=>'4 horas'];
        return view('visita.index',compact('usuarios','usuario_id','tiposVisita','tiempoVisita'));
    }

    public function visitasByUsuario(Request $request,$usuario_id=null){
        $fechaIni = new Carbon($request->get('start'));
        $fechaFin = new Carbon($request->get('end'));
        if($usuario_id==null){
            $usuario_id=Auth::user()->id;
        }
        $visitas = Visita::where("usuario_id",$usuario_id)->whereBetween('fecha_inicio',array($fechaIni->toDateString().' 00:00:00' ,$fechaFin->toDateString().' 23:59:59' ))->with('vendedor')->get();
        foreach($visitas as $visita){
            $visita->title=$visita->cliente->nombre.' Visita: '.$visita->tipoVisita->tipo;
            $visita->description='Visita: '.$visita->tipoVisita->tipo;
            $visita->start=$visita->fecha_inicio;
            $visita->end=$visita->fecha_fin;
            $visita->color=$visita->estado->color;
            $visita->textColor=$visita->estado->textColor;
            $visita->url=route('visita.show',$visita->id);
            $visita->template='userTemplate';
        }
        if(!$request->is('api/*') || $request->get('libres')==0)return $visitas;

        $config = Configuracion::where('empresa_id',Auth::user()->empresa_id)->first();
        $start = Carbon::parse($request->get('start').' '.$config->min_time);
        $end = Carbon::parse($request->get('start').' '.$config->max_time);
        $horas = array();
        do {            
            $horas[]=array(
                'title'=>'Horario disponible',
                'start'=>$start->toDateTimeString(),
                'end'=>$start->addMinutes($config->tiempo_visita)->toDateTimeString(),
                'color'=>'#A389D4',
                'textColor'=>'#fff',
                'template'=>'libreTemplate'
            );            
        } while ($start->lessThanOrEqualTo($end));
        if($visitas->count()>0){
            foreach($horas as $index => $hora){
                foreach($visitas as $visita){
                    $hora['in']=Carbon::parse($visita->fecha_inicio)->between(Carbon::parse($hora['start']),Carbon::parse($hora['end']),false );
                    $hora['out']=Carbon::parse($visita->fecha_fin)->between(Carbon::parse($hora['start']),Carbon::parse($hora['end']) );
                    if(Carbon::parse($visita->fecha_inicio)->between(Carbon::parse($hora['start']),Carbon::parse($hora['end']),true ) && Carbon::parse($visita->fecha_fin)->between(Carbon::parse($hora['start']),Carbon::parse($hora['end']),true ) ) {
                        //if(Carbon::parse($visita->fecha_fin)->between(Carbon::parse($hora['start']),Carbon::parse($hora['end']) )){
                            //unset($horas[$index]);
                            $horas[$index]=$visita;
                            break;
                       // }
                    }
                }
            }
        }
        return $horas;
    }

    public function visitasByUsuarioHistorial(Request $request,$usuario_id=null){
        if($usuario_id==null){
            $usuario_id=Auth::user()->id;
        }
        $visitas = Visita::where("usuario_id",$usuario_id)->with('vendedor')->orderBy('fecha_inicio','desc')->paginate(20);
        foreach($visitas as $visita){
            $visita->title=$visita->cliente->nombre.' Visita: '.$visita->tipoVisita->tipo;
            $visita->description='Visita: '.$visita->tipoVisita->tipo;
            $visita->start=$visita->fecha_inicio;
            $visita->end=$visita->fecha_fin;
            $visita->color=$visita->estado->color;
            $visita->textColor=$visita->estado->textColor;
            $visita->url=route('visita.show',$visita->id);
            $visita->template='userTemplate';
        }
        return $visitas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->all();
        $data['estado_visita_id']=1;
        if(!$request->is('api/*')){
            $data['fecha_inicio']=Carbon::parse($data['fecha'].' '.$data['horaEstimada'])->toDateTimeString();
            $data['fecha_fin']=Carbon::parse($data['fecha'].' '.$data['horaEstimada'])->addMinutes($data['tiempo_visita'])->toDateTimeString();
        }
        $visita=Visita::create($data);
        $validate=true;
        return response()->json(compact('visita','validate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $visita=Visita::find($id);
        $estados=EstadoVisita::get();
        
        if($request->is('api/*')) {
            
            $previsita= $visita->tipoVisita->plantillaPre->detalles()->with(['visita'=>function($query) use($id){
                $query->where('id',$id);
            }])->orderBy('orden')->get();
            $postvisita= $visita->tipoVisita->plantillaVisita->detalles()->with(['visita'=>function($query) use($id){
                $query->where('id',$id);
            }])->orderBy('orden')->get();
            $tareas=Tarea::where('visita_id',$id)->with(['usuario','usuarioCrea'])->get();
            $visita=Visita::where('id',$id)->with(['cliente.clasificacion','vendedor','tipoVisita','estado','contacto.oficina.ciudad'])->first();
            return response()->json(compact('previsita','postvisita','visita','tareas','estados'));
        };
        $tiposVisita=TipoVisita::get()->pluck('tipo','id');
        $tiempoVisita=['10'=>'10 minutos','20'=>'20 minutos','30'=>'30 minutos','45'=>'45 minutos','60'=>'1 hora','90'=>'1 hora y 30 minutos','120'=>'2 horas','180'=>'3 horas','240'=>'4 horas'];
        $visitasAnteriores = Visita::where('cliente_id',$visita->cliente_id)->where('fecha_inicio','<=',Carbon::now()->toDateString())->with(['estado','tipoVisita'])->orderBy('fecha_inicio','desc')->paginate(20);
        $proximaVisita = Visita::where('cliente_id',$visita->cliente_id)->where('fecha_inicio','>',Carbon::now()->toDateString())->with(['estado','tipoVisita'])->first();
        $pest=($request->has('pest'))?$request->get('pest'):'pre';
        return view('visita.show',compact('visita','estados','tiposVisita','tiempoVisita','visitasAnteriores','proximaVisita','pest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data=$request->all();
        $visita = Visita::find($id);
        $visita->update($data);
        if(!$request->is('api/*') && $visita->estado_visita_id==6) return back();
        return $visita;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function cambiaEstado($id,$estado_id){
        $visita = Visita::find($id);
        $visita->estado_visita_id=$estado_id;
        $visita->save();
        return back();
    }

    public function savePrevisita(Request $request,$id){
        if($request->is('api/*')){
            $visita = Visita::find($id)->detalles();
            if( PlantillaDetalle::find($request->get('id'))->tipo_campo!=6){
                $visita->detach($request->get('id'));
                $visita->attach($request->get('id'),['valor'=>$request->get('valor')]);
            }else{
                if($request->get('value')=='0'){
                    DB::delete('delete from plantilla_detalles_visitas where plantilla_detalle_id = ? and visita_id = ? and valor = ? ', [$request->get('id'),$id,$request->get('valor')]);    
                }else{
                    if($visita->wherePivot('valor',$request->get('valor'))->get()->count()>0){
                        DB::delete('delete from plantilla_detalles_visitas where plantilla_detalle_id = ? and visita_id=? and valor=?', [$request->get('id'),$id,$request->get('valor')]);
                    }
                    $visita->attach($request->get('id'),['valor'=>$request->get('valor')]);
                }                
            }            
            return response()->json(['guardado'=>true]);
        }else{
            $inputs = $request->except(['_token','pest']);
            $visita = Visita::find($id)->detalles();
            foreach($inputs as $key => $input){
                $val=explode('_',$key);
                if( PlantillaDetalle::find($val[1])->tipo_campo!=6){
                    $visita->detach($val[1]);
                    $visita->attach($val[1],['valor'=>$input]);
                }else{
                    DB::delete('delete from plantilla_detalles_visitas where plantilla_detalle_id = ? and visita_id = ?', [$val[1],$id]);    
                    foreach($input as $value){
                        $visita->attach($val[1],['valor'=>$value]);
                    }                    
                }                
            }
            return redirect('e/visita/'.$id.'?pest=pre');
        }
    }

    public function saveVisita(Request $request,$id){
        $inputs = $request->except(['_token','pest']);
        $visita = Visita::find($id)->detalles();
        foreach($inputs as $key => $input){
            $val=explode('_',$key)[1];
            if( PlantillaDetalle::find($val)->tipo_campo!=6){
                $visita->detach($val);
                $visita->attach($val,['valor'=>$input]);
            }else{
                DB::delete('delete from plantilla_detalles_visitas where plantilla_detalle_id = ? and visita_id = ?', [$val[1],$id]);    
                foreach($input as $value){
                    $visita->attach($val[1],['valor'=>$value]);
                }
            }                
        }
        return redirect('e/visita/'.$id.'?pest=post');
    }

    public function tareasVisita(Request $request ,$id){
        $tareas=Tarea::where('visita_id',$id)->with(['usuario','usuarioCrea'])->get();
        return response()->json(compact('tareas'));
    }
}
