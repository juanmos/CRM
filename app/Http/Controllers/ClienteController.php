<?php

namespace App\Http\Controllers;

use App\Imports\ClientesImport;
use App\Models\Ciudad;
use App\Models\Clasificacion;
use App\Models\Cliente;
use App\Models\Pais;
use App\Models\TipoVisita;
use App\Models\User;
use App\Models\Visita;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\Datatables\Datatables;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $usuario_id = null)
    {
        if ($request->is('api/*')) {
            if (Auth::user()->hasRole('Administrador')) {
                $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
                $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)
                        ->orderBy('nombre')
                        ->with(['facturacion', 'vendedor', 'clasificacion', 'contactos', 'oficinas.ciudad']);
                if ($usuario_id != null && $usuario_id != 0) {
                    $clientes = $clientes->where('usuario_id', $usuario_id)->paginate(50);
                } else {
                    $clientes = $clientes->paginate(50);
                }
            } else {
                $usuarios = User::where('id', $usuario_id)->orderBy('nombre')->paginate(50);
                $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)
                //->where('usuario_id',$usuario_id)
                ->orderBy('nombre')->with(['facturacion', 'vendedor', 'clasificacion', 'contactos', 'oficinas.ciudad'])
                ->paginate(20);
            }

            return response()->json(compact('clientes', 'usuario_id'));
        }

        return view('cliente.index', compact('usuario_id'));
    }

    public function clientesData(Request $request, $usuario_id = null)
    {
        if (Auth::user()->hasRole('Administrador')) {
            $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)
                ->orderBy('nombre')
                ->with(['facturacion', 'vendedor', 'clasificacion', 'contactos', 'oficinas.ciudad']);
            if ($usuario_id != null && $usuario_id != 0) {
                $clientes = $clientes->where('usuario_id', '!=', $usuario_id)->get();
            } else {
                $clientes = $clientes->get();
            }
        } else {
            // $usuarios = User::where('id', $usuario_id)->orderBy('nombre')->get();
            $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id)
                //->where('usuario_id',$usuario_id)
                ->orderBy('nombre')->with(['facturacion', 'vendedor', 'clasificacion', 'contactos', 'oficinas.ciudad'])
                ->get();
        }
        return Datatables::of($clientes)->make(true);
    }

    public function buscar(Request $request, $usuario_id = null)
    {
        $clientes = Cliente::where('empresa_id', Auth::user()->empresa_id);
        if ($usuario_id != null) {
            $clientes = $clientes->where('usuario_id', $usuario_id);
        }
        $clientes = $clientes->where('nombre', 'like', '%' . $request->get('buscar') . '%')->orderBy('nombre')->with(['clasificacion'])->paginate(50);
        return response()->json(compact('clientes', 'usuario_id'));
    }

    public function visitas(Request $request, $id)
    {
        if ($request->is('api/*')) {
            $visitas = Visita::where('cliente_id', $id)->with('cliente')->orderBy('fecha_inicio', 'desc')->paginate(20);
        } else {
            $fechaIni = new Carbon($request->get('start'));
            $fechaFin = new Carbon($request->get('end'));
            $visitas  = Visita::where('cliente_id', $id)->whereBetween('fecha_inicio', [$fechaIni->toDateString() . ' 00:00:00', $fechaFin->toDateString() . ' 23:59:59'])->get();
        }

        foreach ($visitas as $visita) {
            $visita->title = $visita->vendedor->full_name . ' Visita: ' . $visita->tipoVisita->tipo;

            $visita->description = 'Visita: ' . $visita->tipoVisita->tipo;
            $visita->start       = $visita->fecha_inicio;
            $visita->end         = $visita->fecha_fin;
            $visita->color       = $visita->estado->color;
            $visita->textColor   = $visita->estado->textColor;
            $visita->url         = route('visita.show', $visita->id);
        }
        return $visitas;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente       = null;
        $clasificacion = Clasificacion::get()->pluck('clasificacion', 'id');
        $paises        = Pais::orderBy('pais')->get()->pluck('pais', 'id');
        $ciudades      = Ciudad::orderBy('ciudad')->get()->pluck('ciudad', 'id');
        $vendedores    = User::where('empresa_id', Auth::user()->empresa_id)->get()->pluck('full_name', 'id');
        return view('cliente.form', compact('cliente', 'clasificacion', 'ciudades', 'vendedores', 'paises'));
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
            'clasificacion_id'=>$request->get('clasificacion_id'),
            'usuario_id'=>$request->get('usuario_id'),
            'empresa_id'=>Auth::user()->empresa_id,
        ]);
        $cliente->facturacion()->create([
            'nombre'=>$request->get('nombre'),
            'telefono_facturacion'=>$request->get('telefono_facturacion'),
            'direccion'=>$request->get('direccion'),
            'email'=>$request->get('email'),
            'ruc'=>$request->get('ruc'),
        ]);
        $oficina = $cliente->oficinas()->create([
            'pais_id'=>$request->get('pais_id'),
            'ciudad_id'=>$request->get('ciudad_id'),
            'direccion'=>$request->get('direccion'),
            'matriz'=>1,
        ]);
        $cliente->contactos()->create([
            'nombre'=>$request->get('nombre_contacto'),
            'apellido'=>$request->get('apellido_contacto'),
            'email'=>$request->get('email_contacto'),
            'telefono'=>$request->get('telefono_contacto'),
            'extension'=>$request->get('extension_contacto'),
            'cargo'=>$request->get('cargo_contacto'),
            'ciudad_id'=>$request->get('ciudad_id'),
            'oficina_id'=>$oficina->id,
        ]);
        if ($request->is('api/*')) {
            return response()->json(['created'=>true]);
        }
        return redirect('cliente/' . $cliente->id)->with('mensaje', 'Cliente creado con exito!');
    }

    public function clienteRapido(Request $request)
    {
        $cliente = Cliente::create([
            'nombre'=>$request->get('nombre'),
            'telefono'=>$request->get('telefono'),
            'clasificacion_id'=>1,
            'usuario_id'=>Auth::user()->id,
            'empresa_id'=>Auth::user()->empresa_id,
        ]);
        $cliente->facturacion()->create([
            'nombre'=>$request->get('nombre'),
            'direccion'=>$request->get('direccion'),
        ]);
        $oficina = $cliente->oficinas()->create([
            'pais_id'=>1,
            'ciudad_id'=>1,
            'direccion'=>$request->get('direccion'),
            'matriz'=>1,
        ]);
        if ($request->has('nombre_contacto') && $request->get('nombre_contacto') != '') {
            $cliente->contactos()->create([
                'nombre'=>$request->get('nombre_contacto'),
                'apellido'=>$request->get('nombre_contacto'),
                'ciudad_id'=>1,
                'oficina_id'=>$oficina->id,
            ]);
        }

        if ($request->is('api/*')) {
            return response()->json(['created'=>true, 'cliente'=>$cliente]);
        }
        return redirect('cliente/' . $cliente->id)->with('mensaje', 'Cliente creado con exito!');
    }

    public function vendedor($id)
    {
        $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->where('activo', 1)->orderBy('nombre')->paginate(50);
        return view('usuario.index', compact('usuarios', 'id'));
    }

    public function asignar($id, $cliente_id)
    {
        $cliente             = Cliente::find($cliente_id);
        $cliente->usuario_id = $id;
        $cliente->save();
        return redirect('cliente/' . $cliente_id);
    }

    public function asignarMultiple(Request $request, $id)
    {
        $clientes = Cliente::whereIn('id', $request->get('clientes'))->get();
        foreach ($clientes as $cliente) {
            $cliente->usuario_id = $id;
            $cliente->save();
        }
        return redirect('e/usuario/' . $id);
    }

    public function desasignar($id, $cliente_id)
    {
        $cliente             = Cliente::find($cliente_id);
        $cliente->usuario_id = 0;
        $cliente->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente      = Cliente::find($id);
        $tiposVisita  = TipoVisita::where('empresa_id', 0)->orWhere('empresa_id', Auth::user()->empresa_id)->orderBy('tipo')->get();
        $tiempoVisita = [10=>'10 minutos', 15=>'15 minutos', 20=>'20 minutos', 30=>'30 minutos', 45=>'45 minutos', 60=>'60 minutos', 90=>'1 hora y 30 minutos', 120=>'2 horas', 180=>'3 horas', '240'=>'4 horas'];

        return view('cliente.show', compact('cliente', 'tiposVisita', 'tiempoVisita'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente       = Cliente::find($id);
        $clasificacion = Clasificacion::get()->pluck('clasificacion', 'id');
        $ciudades      = Ciudad::orderBy('ciudad')->get()->pluck('ciudad', 'id');
        $paises        = Pais::orderBy('pais')->get()->pluck('pais', 'id');
        $vendedores    = User::where('empresa_id', Auth::user()->empresa_id)->get()->pluck('full_name', 'id');
        return view('cliente.form', compact('cliente', 'clasificacion', 'ciudades', 'vendedores', 'paises'));
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
            'usuario_id'=>$request->get('usuario_id'),
            'empresa_id'=>Auth::user()->empresa_id,
        ]);
        $cliente->facturacion()->update([
            'nombre'=>$request->get('nombre'),
            'telefono_facturacion'=>$request->get('telefono_facturacion'),
            'direccion'=>$request->get('direccion'),
            'email'=>$request->get('email'),
            'ruc'=>$request->get('ruc'),
        ]);
        return redirect('cliente')->with('mensaje', 'Cliente actualizado con exito!');
    }

    public function actualizaCliente(Request $request)
    {
        $cliente = Cliente::find($request->get('id'));
        $cliente->update([
            'nombre'=>$request->get('nombre'),
            'telefono'=>$request->get('telefono'),
            'web'=>$request->get('web'),
            //'activo'=>$request->get('activo'),
            'clasificacion_id'=>$request->get('clasificacion_id'),
            //'usuario_id'=>$request->get(''),
            'empresa_id'=>Auth::user()->empresa_id,
        ]);
        return response()->json(compact('cliente'));
    }

    public function actualizaFacturacion(Request $request)
    {
        $cliente = Cliente::find($request->get('id'));
        $cliente->facturacion->update([
            'nombre'=>$request->get('nombre'),
            'telefono_facturacion'=>$request->get('telefono_facturacion'),
            'direccion'=>$request->get('direccion'),
            'email'=>$request->get('email'),
            'ruc'=>$request->get('ruc'),
        ]);
        return response()->json(compact('cliente'));
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
