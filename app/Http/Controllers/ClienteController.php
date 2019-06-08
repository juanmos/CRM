<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Auth;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clientes = Cliente::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(20);
        return view('cliente.index',compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente=null;
        $clasificacion=Clasificacion::get()->pluck('clasificacion','id');
        return view('cliente.form',compact('cliente','clasificacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cliente = Cliente::create([
            'nombre'=>$request->get('nombre'),
            'telefono'=>$request->get('telefono'),
            'web'=>$request->get('web'),
            //'activo'=>$request->get('activo'),
            'clasificacion_id'=>$request->get('clasificacion_id'),
            //'usuario_id'=>$request->get(''),
            'empresa_id'=>Auth::user()->empresa_id
        ]);
        $cliente->facturacion()->create([
            'nombre'=>$request->get('nombre'),
            'telefono_facturacion'=>$request->get('telefono_facturacion'),
            'direccion'=>$request->get('direccion'),
            'email'=>$request->get('email'),
            'ruc'=>$request->get('ruc'),
        ]);
        return redirect('cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $cliente=Cliente::find($id);
        return view('cliente.show',compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $cliente=Cliente::find($id);
        $clasificacion=Clasificacion::get()->pluck('clasificacion','id');
        return view('cliente.form',compact('cliente','clasificacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);
        $cliente->update([
            'nombre'=>$request->get('nombre'),
            'telefono'=>$request->get('telefono'),
            'web'=>$request->get('web'),
            //'activo'=>$request->get('activo'),
            'clasificacion_id'=>$request->get('clasificacion_id'),
            //'usuario_id'=>$request->get(''),
            'empresa_id'=>Auth::user()->empresa_id
        ]);
        $cliente->facturacion()->update([
            'nombre'=>$request->get('nombre'),
            'telefono_facturacion'=>$request->get('telefono_facturacion'),
            'direccion'=>$request->get('direccion'),
            'email'=>$request->get('email'),
            'ruc'=>$request->get('ruc'),
        ]);
        return redirect('cliente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
