<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use App\Models\Empresa;
use App\Models\Visita;
use App\Models\Ciudad;
use App\Models\Cliente;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresa::orderBy('nombre')->paginate(50);
        return view('empresa.index',compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa = null;
        $ciudad = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        return view('empresa.form',compact('empresa','ciudad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $empresa = Empresa::create($request->all());
        $empresa->configuracion()->create();
        return redirect('empresa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $empresa = Empresa::find($id);
        $clientes = Cliente::where('empresa_id',$id)->get();
        $visitas = Visita::whereHas('cliente',function($query) use($clientes){
            $query->whereIn('cliente_id',$clientes->pluck('id'));
        })->get()->count();
        $visitasTerminadas = Visita::whereHas('cliente',function($query) use($clientes){
            $query->whereIn('cliente_id',$clientes->pluck('id'));
        })->where('estado_visita_id',5)->get()->count();
        return view('empresa.show',compact('empresa','visitas','visitasTerminadas','clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa = Empresa::find($id);
        $ciudad = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        return view('empresa.form',compact('empresa','ciudad'));
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
        $empresa = Empresa::find($id)->update($request->all());
        return redirect('empresa/'.$id);
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
