<?php

namespace App\Http\Controllers;

use App\Models\Clasificacion;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($usuario_id=null)
    {
        $clientes = Cliente::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(20);
        return view('cliente.index',compact('clientes','usuario_id'));
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

    public function vendedor($id){
        $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->where('activo',1)->orderBy('nombre')->paginate(50);
        return view('usuario.index',compact('usuarios','id'));
    }

    public function asignar($id,$cliente_id){
        $cliente = Cliente::find($cliente_id);
        $cliente->usuario_id=$id;
        $cliente->save();
        return redirect('cliente/'.$cliente_id);
    }
    public function asignarMultiple(Request $request,$id){
        $clientes = Cliente::whereIn('id',$request->get('clientes'))->get();
        foreach($clientes as $cliente){
            $cliente->usuario_id=$id;
            $cliente->save();
        }
        return redirect('e/usuario/'.$id);
    }
    public function desasignar($id,$cliente_id){
        $cliente = Cliente::find($cliente_id);
        $cliente->usuario_id=0;
        $cliente->save();
        return back();
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
