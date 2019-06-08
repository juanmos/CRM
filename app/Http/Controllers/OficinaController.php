<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Oficina;

class OficinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cliente_id)
    {
        $oficina = null;
        $ciudades = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        return view('oficina.form',compact('oficina','cliente_id','ciudades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$cliente_id)
    {
        Oficina::create([
            'direccion'=>$request->get('direccion'),
            'matriz'=>$request->get('matriz'),
            'ciudad_id'=>$request->get('ciudad_id'),
            'cliente_id'=>$cliente_id
        ]);
        return redirect('cliente/'.$cliente_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oficina = Oficina::find($id);
        $ciudades = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        return view('oficina.form',compact('oficina','ciudades'));
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
        $oficina=Oficina::find($id);
        $oficina->update([
            'direccion'=>$request->get('direccion'),
            'matriz'=>$request->get('matriz'),
            'ciudad_id'=>$request->get('ciudad_id')
        ]);
        return redirect('cliente/'.$oficina->cliente_id);
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
