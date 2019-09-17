<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlantillaDetalle;
use App\Models\Plantilla;
use Auth;

class PlantillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->hasRole('SuperAdministrador')){
            $plantillas = Plantilla::where('empresa_id',0)->orderBy('nombre')->get();
        }else{
            $plantillas = Plantilla::where('empresa_id',0)->orWhere('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->get();
        }
        
        return view('plantilla.index',compact('plantillas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $plantilla = null;
        return view('plantilla.form',compact('plantilla'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =$request->all();
        $data['empresa_id']=Auth::user()->empresa_id;
        Plantilla::create($data);
        return redirect('plantilla');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $plantilla = Plantilla::find($id);
        return view('plantilla.show',compact('plantilla'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plantilla = Plantilla::find($id);
        return view('plantilla.form',compact('plantilla'));
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
        Plantilla::find($id)->update($request->all());
        return redirect('plantilla');
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

    public function creaCampo(Request $request,$id){
        $plantilla = Plantilla::find($id);
        $data=$request->all();
        if($data['id']>0){
            $plantilla->detalles()->where('id',$data['id'])->first()->update($data);
        }else{
            $data['orden']=$plantilla->detalles()->count();
            $plantilla->detalles()->create($data);
        }

        return response()->json(['campos'=>$plantilla->detalles()->orderBy('orden')->get()]);
    }

    public function opcionesCampo(Request $request){
        $detalle = PlantillaDetalle::find($request->get('id'));
        $detalle->opciones=implode('|',$request->get('opciones'));
        $detalle->save();
        return response()->json(['campos'=>Plantilla::find($detalle->plantilla_id)->detalles()->orderBy('orden')->get()]);
    }

    public function eliminarCampo(Request $request){
        $detalle = PlantillaDetalle::find($request->get('id'));
        $plantilla = Plantilla::find($detalle->plantilla_id);
        $detalle->delete();
        return response()->json(['campos'=>$plantilla->detalles()->orderBy('orden')->get()]);
    }

    public function ordenCampo(Request $request,$id){
        $plantilla = Plantilla::find($id);
        $ids = explode(',',$request->get('ids'));
        foreach($ids as $index => $id){
            $detalle = PlantillaDetalle::find($id);
            $detalle->orden=$index+1;
            $detalle->save();
        }
        return response()->json(['ordenado'=>true]);
    }
}
