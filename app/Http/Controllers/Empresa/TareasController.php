<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\Visita;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class TareasController extends Controller
{
    public function index(Request $request,$usuario_id=null){
        
        if($usuario_id==null){
            $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
            $usuario_id=$usuarios->first()->id;
        }elseif(Auth::user()->hasRole('Administrador')){
            $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        }else{
            $usuarios = User::where('id',$usuario_id)->orderBy('nombre')->paginate(50);
        }
        $visitas = Visita::where('usuario_id',$usuario_id)->has('tareas')->with(['cliente','tareas','tipoVisita','estado'])->paginate(50);
        $tareas = Tarea::where('usuario_id',$usuario_id)->where('visita_id',0)->paginate(50);
        return view('tareas.index',compact('usuarios','usuario_id','visitas','tareas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        if($request->has('visita_id') && $data['visita_id']!=null){
            $visita = Visita::find($request->get('visita_id'));
            $data['usuario_id']=$visita->usuario_id;
            $data['usuario_crea_id']=Auth::user()->id;
            $visita->tareas()->create($data);
        }else{
            $data['usuario_id']=$data['usuario_id'];
            $data['usuario_crea_id']=Auth::user()->id;
            $data['visita_id']=0;
            Tarea::create($data);
        }
        
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
    public function update(Request $request)
    {
        $tarea = Tarea::find($request->get('id'));
        $tarea->realizado=$request->get('valor');
        if($request->get('valor')==1){
            $tarea->fecha_completada=Carbon::now()->toDateTimeString();
        }
        $tarea->save();
        return response()->json(['id'=>$tarea->id]);
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
}