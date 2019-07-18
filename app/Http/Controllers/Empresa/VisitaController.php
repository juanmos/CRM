<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TipoVisita;
use App\Models\Empresa;
use App\Models\Visita;
use App\Models\EstadoVisita;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class VisitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$usuario_id=null)
    {
        $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        if($usuario_id==null){
            $usuario_id=$usuarios->first()->id;
        }
        $tiposVisita = TipoVisita::where('empresa_id',0)->orWhere('empresa_id',Auth::user()->empresa_id)->orderBy('tipo')->get()->pluck('tipo','id');
        $tiempoVisita=['10'=>'10 minutos','20'=>'20 minutos','30'=>'30 minutos','45'=>'45 minutos','60'=>'1 hora','90'=>'1 hora y 30 minutos','120'=>'2 horas','180'=>'3 horas','240'=>'4 horas'];
        return view('visita.index',compact('usuarios','usuario_id','tiposVisita','tiempoVisita'));
    }

    public function visitasByUsuario(Request $request,$usuario_id){
        $fechaIni = new Carbon($request->get('start'));
        $fechaFin = new Carbon($request->get('end'));
        $visitas = Visita::where("usuario_id",$usuario_id)->whereBetween('fecha_inicio',array($fechaIni->toDateString().' 00:00:00' ,$fechaFin->toDateString().' 23:59:59' ))->get();
        foreach($visitas as $visita){
            $visita->title=$visita->cliente->nombre.' Visita: '.$visita->tipoVisita->tipo;
            $visita->description='Visita: '.$visita->tipoVisita->tipo;
            $visita->start=$visita->fecha_inicio;
            $visita->end=$visita->fecha_fin;
            $visita->color=$visita->estado->color;
            $visita->textColor=$visita->estado->textColor;
            $visita->url=route('visita.show',$visita->id);
        }
        return $visitas;//response()->json(compact('visitas'));
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
        $data['fecha_inicio']=Carbon::parse($data['fecha'].' '.$data['horaEstimada'])->toDateTimeString();
        $data['fecha_fin']=Carbon::parse($data['fecha'].' '.$data['horaEstimada'])->addMinutes($data['tiempo_visita'])->toDateTimeString();
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
    public function show($id)
    {
        $visita=Visita::find($id);
        $estados=EstadoVisita::get();
        $tiposVisita=TipoVisita::get()->pluck('tipo','id');
        $tiempoVisita=['10'=>'10 minutos','20'=>'20 minutos','30'=>'30 minutos','45'=>'45 minutos','60'=>'1 hora','90'=>'1 hora y 30 minutos','120'=>'2 horas','180'=>'3 horas','240'=>'4 horas'];
        $visitasAnteriores = Visita::where('cliente_id',$visita->cliente_id)->where('fecha_inicio','<=',Carbon::now()->toDateString())->with(['estado','tipoVisita'])->orderBy('fecha_inicio','desc')->paginate(20);
        $proximaVisita = Visita::where('cliente_id',$visita->cliente_id)->where('fecha_inicio','>',Carbon::now()->toDateString())->with(['estado','tipoVisita'])->first();
        return view('visita.show',compact('visita','estados','tiposVisita','tiempoVisita','visitasAnteriores','proximaVisita'));
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
        $inputs = $request->except(['_token']);
        $visita = Visita::find($id)->detalles();
        foreach($inputs as $key => $input){
            $val=explode('_',$key)[1];
            $visita->detach($val);
            $visita->attach($val,['valor'=>$input]);
        }
        return back();
    }

    public function saveVisita(Request $request,$id){
        $inputs = $request->except(['_token']);
        $visita = Visita::find($id)->detalles();
        foreach($inputs as $key => $input){
            $val=explode('_',$key)[1];
            $visita->detach($val);
            $visita->attach($val,['valor'=>$input]);
        }
        return back();
    }
}
