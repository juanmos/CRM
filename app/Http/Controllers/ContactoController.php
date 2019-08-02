<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Contacto;
use App\Models\Oficina;
use Auth;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function buscar(Request $request){
        $contacto = Contacto::where('cliente_id',$request->get('cliente_id'))->get();
        return $contacto;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($cliente_id)
    {
        $contacto = null;
        $ciudades = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        $oficinas = Oficina::orderBy('direccion')->get()->pluck('direccion','id');
        return view('contacto.form',compact('contacto','cliente_id','ciudades','oficinas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$cliente_id)
    {
        Contacto::create([
            'cliente_id'=>$cliente_id,
            'nombre'=>$request->get('nombre'),
            'apellido'=>$request->get('apellido'),
            'email'=>$request->get('email'),
            'telefono'=>$request->get('telefono'),
            'extension'=>$request->get('extension'),
            'cargo'=>$request->get('cargo'),
            'ciudad_id'=>$request->get('ciudad_id'),
            'oficina_id'=>$request->get('oficina_id')
        ]);
        if($request->is('api/*')) {
            $contactos=Contacto::where('cliente_id',$cliente_id)->orderBy('nombre')->get();
            return response()->json(compact('contactos'));
        }
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contacto = Contacto::find($id);
        $ciudades = Ciudad::orderBy('ciudad')->get()->pluck('ciudad','id');
        $oficinas = Oficina::orderBy('direccion')->get()->pluck('direccion','id');
        return view('contacto.form',compact('contacto','cliente_id','ciudades','oficinas'));
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
        $contacto=Contacto::find($id);
        $contacto->update([
            'nombre'=>$request->get('nombre'),
            'apellido'=>$request->get('apellido'),
            'email'=>$request->get('email'),
            'telefono'=>$request->get('telefono'),
            'extension'=>$request->get('extension'),
            'cargo'=>$request->get('cargo'),
            'ciudad_id'=>$request->get('ciudad_id'),
            'oficina_id'=>$request->get('oficina_id')
        ]);
        if($request->is('api/*')) {
            $contactos=Contacto::where('cliente_id',$contacto->cliente_id)->orderBy('nombre')->get();
            return response()->json(compact('contactos'));
        }
        return redirect('cliente/'.$contacto->cliente_id);
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
