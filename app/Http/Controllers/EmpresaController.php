<?php

namespace App\Http\Controllers;

use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\Empresa;
use App\Models\Visita;
use App\Notifications\EmpresaRegistradaNotification;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        return view('empresa.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa = null;
        $ciudad  = Ciudad::orderBy('ciudad')->get()->pluck('ciudad', 'id');
        return view('empresa.form', compact('empresa', 'ciudad'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->is('api/*')) {
            $dataEmp                        = [];
            $dataEmp['nombre']              = $request->get('empresa');
            $dataEmp['costo']               = 0;
            $dataEmp['fecha_inicio']        = Carbon::now()->toDateString();
            $dataEmp['fecha_fin_pruebas']   = Carbon::now()->addDays(60)->toDateString();
            $dataEmp['ciudad_id']           = 1;
            $dataEmp['pruebas']             = 1;
            $dataEmp['usuarios_permitidos'] = 3;
            $empresa                        = Empresa::create($dataEmp);
            $empresa->configuracion()->create();
            $data             = $request->only(['email', 'nombre', 'apellido', 'telefono']);
            $data['password'] = bcrypt($request->get('password'));
            $usuario          = $empresa->usuarios()->create($data);
            $usuario->syncRoles('Administrador');
            if ($request->has('foto') && $request->get('foto') != null) {
                $usuario->foto = $request->file('foto')->store('public/usuarios');
                $usuario->save();
            }
            $usuario->notify(new EmpresaRegistradaNotification($usuario, $request->get('password')));
            return response()->json(['creado'=>true]);
        } else {
            $empresa = Empresa::create($request->all());
            $empresa->configuracion()->create();
        }
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
        if (auth()->user()->hasRole('SuperAdministrador')) {
            $empresa = Empresa::find($id);
        } elseif (auth()->user()->empresa_id != $id) {
            abort(401, 'No autorizado');
        } else {
            $empresa = Empresa::find(auth()->user()->empresa_id);
        }
        if (auth()->user()->primer_login) {
            return redirect('/e/usuario/' . $user->id . '/edit')->with('info', 'Debes cambiar tu contraseña e ingresar tu foto');
        }

        $clientes = Cliente::where('empresa_id', $empresa->id)->get();
        $visitas  = Visita::whereHas('cliente', function ($query) use ($clientes) {
            $query->whereIn('cliente_id', $clientes->pluck('id'));
        })->get()->count();
        $visitasTerminadas = Visita::whereHas('cliente', function ($query) use ($clientes) {
            $query->whereIn('cliente_id', $clientes->pluck('id'));
        })->where('estado_visita_id', 5)->get()->count();
        if (Auth::user()->hasRole('Administrador')) {
            $usuarios = $empresa->usuarios;
        } elseif (Auth::user()->hasRole('JefeVentas')) {
            $usuarios = User::where('empresa_id', $user->empresa_id)->where('user_id', $user->id)->get();
            $usuarios->push($user);
        } else {
            $usuarios = User::where('id', $user->id)->get();
        }

        return view('empresa.show', compact('empresa', 'visitas', 'visitasTerminadas', 'clientes', 'usuarios'));
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
        $ciudad  = Ciudad::orderBy('ciudad')->get()->pluck('ciudad', 'id');
        return view('empresa.form', compact('empresa', 'ciudad'));
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
        return redirect('empresa/' . $id);
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
