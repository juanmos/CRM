<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\Visita;
use Carbon\Carbon;
use Auth;

class TareasController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $visita = Visita::find($request->get('visita_id'));
        $data['usuario_id']=$visita->usuario_id;
        $data['usuario_crea_id']=Auth::user()->id;
        $visita->tareas()->create($data);
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
