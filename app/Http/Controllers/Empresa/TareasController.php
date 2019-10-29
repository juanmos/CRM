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
        $elUser=User::find($usuario_id);
        if($usuario_id==null){
            $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
            $usuario_id=$usuarios->first()->id;
            $elUser=Auth::user();
        }elseif(Auth::user()->hasRole('Administrador')){
            $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        }elseif(Auth::user()->hasRole('JefeVentas')){
            $usuarios = User::where('user_id',$usuario_id)->orWhere('id',$usuario_id)->orderBy('nombre')->paginate(50);
        }else{
            $usuarios = User::where('id',$usuario_id)->orderBy('nombre')->paginate(50);
        }
        $visitas = Visita::where('usuario_id',$usuario_id)->has('tareas')->with(['cliente','tareas.usuario','tareas.usuarioCrea','tipoVisita','estado','tareas.usuarios_adicionales'])->paginate(50);
        $tareas =  $tareas = Tarea::where(function($query) use($usuario_id){
            $query->orWhere('usuario_id',$usuario_id);
            $query->orWhereHas('usuarios_adicionales',function($query2) use($usuario_id){
                $query2->where('tarea_users.user_id',$usuario_id);
            });
        })->with(['usuario','usuarioCrea','usuarios_adicionales'])->paginate(50);
        $tareasHoy = Tarea::where(function($query) use($usuario_id){
            $query->orWhere('usuario_id',$usuario_id);
            $query->orWhereHas('usuarios_adicionales',function($query2) use($usuario_id){
                $query2->where('tarea_users.user_id',$usuario_id);
            });
        })->whereBetween('fecha',[Carbon::now()->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59'])->with(['usuario','usuarioCrea','usuarios_adicionales'])->paginate(50);
        
        if($request->is('api/*')) return response()->json(compact('usuarios','usuario_id','visitas','tareas','tareasHoy','elUser'));
        return view('tareas.index',compact('usuarios','usuario_id','visitas','tareas','tareasHoy','elUser'));
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
        if($data['recordatorio']!=null){
            $data['fecha_notificacion']=Carbon::parse($data['fecha'])->subMinutes($data['recordatorio'])->toDateTimeString();
        }
        $data['usuario_crea_id']=Auth::user()->id;
        if($request->has('visita_id') && $data['visita_id']!=null){
            $visita = Visita::find($request->get('visita_id'));
            $data['usuario_id']=$visita->usuario_id;            
            $visita->tareas()->create($data);
            if($request->is('api/*')) return response()->json(['created'=>true]);
            return redirect('e/visita/'.$visita->id.'?pest=T')->with('mensaje','Datos de tarea guardados');
        }else{
            $data['usuario_id']=$data['usuario_id'];
            $data['visita_id']=0;
            Tarea::create($data);
        }
        
        if($request->is('api/*')) return response()->json(['created'=>true]);
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
        ($request->has('nombre'))?$tarea->nombre=$request->get('nombre'):'';
        ($request->has('detalle'))?$tarea->detalle=$request->get('detalle'):'';
        ($request->has('fecha'))?$tarea->fecha=$request->get('fecha'):'';
        if($request->has('recordatorio')){
            $tarea->fecha_notificacion=Carbon::parse($tarea->fecha)->subMinutes($request->get('recordatorio'))->toDateTimeString();
        }
        if($request->has('valor')){
            $tarea->realizado=$request->get('valor');
            if($request->get('valor')==1){
                $tarea->fecha_completada=Carbon::now()->toDateTimeString();
            }
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
    public function destroy(Request $request,$id)
    {
        $tarea = Tarea::find($id);
        $tarea->delete();
        if($request->is('api/*')){
            return response()->json(['eliminado'=>true]);
        }
        return back()->with('mensaje','Tarea eliminada');
    }

    public function addUser(Request $request){
        $tarea=Tarea::find($request->get('tarea_id'));
        if($request->is('api/*')){
            $tarea->usuarios_adicionales()->attach($request->get('usuarios'));
            return response()->json(['eliminado'=>true]);
        }else{
            $tarea->usuarios_adicionales()->sync($request->get('usuarios'));
            return back();
        }
    }
    public function deleteUser(Request $request,$user_id,$tarea_id){
        $tarea=Tarea::find($tarea_id);
        $tarea->usuarios_adicionales()->detach($user_id);
        if($request->is('api/*')) return response()->json(['eliminado'=>true]);
        return back();
    }
}
