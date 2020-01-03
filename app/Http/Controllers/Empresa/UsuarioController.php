<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Notifications\NuevoUsuarioNotification;
use App\Http\Controllers\Controller;
use App\Models\TipoVisita;
use App\Models\Empresa;
use App\Models\Visita;
use App\Models\User;
use Carbon\Carbon;
use Auth;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user= User::find(Auth::user()->id);
        if (Auth::user()->hasRole('Administrador')) {
            $usuarios=User::where('empresa_id', $user->empresa_id)->with('roles')->paginate(50);
        } elseif (Auth::user()->hasRole('JefeVentas')) {
            $usuarios=User::where('empresa_id', $user->empresa_id)->where(function ($query) use ($user) {
                $query->orWhere('user_id', $user->id);
                $query->orWhere('id', $user->id);
            })->with('roles')->paginate(50);
        // $usuarios->push($user);
        } else {
            $usuarios=User::where('id', $user->id)->with('roles')->get();
        }
        //$usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        if ($request->is('api/*')) {
            return response()->json(compact('usuarios'));
        }
        return view('usuario.index', compact('usuarios'));
    }

    public function eliminados()
    {
        if (Auth::user()->hasRole('SuperAdministrador')) {
            $usuarios = User::orderBy('nombre')->onlyTrashed()->paginate(50);
        } else {
            $usuarios = User::where('empresa_id', Auth::user()->empresa_id)->orderBy('nombre')->onlyTrashed()->paginate(50);
        }
        return view('usuario.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id=null)
    {
        if (Auth::user()->hasRole('SuperAdministrador')) {
            $empresa=Empresa::find($id);
        } else {
            $empresa=Empresa::find(Auth::user()->empresa_id);
        }
        $usuario = null;
        if (Auth::user()->hasRole('Administrador')) {
            $roles = Role::orderBy('name')->whereNotIn('name', ['SuperAdministrador'])->get()->pluck('name', 'name');
        } else {
            $roles = Role::orderBy('name')->whereIn('name', ['Vendedor'])->get()->pluck('name', 'name');
        }
        return view('usuario.form', compact('empresa', 'id', 'usuario', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data=$request->except(['foto','password']);
        $email = User::where('email', $data['email'])->withTrashed()->get();
        if ($email->count()>0) {
            return back()->withErrors(['email'=>'Email ya existe'])->withInput();
        }
        if ($request->has('password')) {
            if (strlen($request->get('password'))>5) {
                $data['password']=bcrypt($request->get('password'));
            } else {
                return back()->withErrors(['password'=>'Contraseña demasiado corta, minimo 6 caracteres'])->withInput();
            }
        }
        $usuario = User::create($data);
        if ($request->has('foto')) {
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        
        $usuario->syncRoles($request->get('role'));
        if ($usuario->empresa_id==0) {
            $usuario->empresa_id=Auth::user()->empresa_id;
            $usuario->save();
        }
        $usuario->notify(new NuevoUsuarioNotification($usuario, $request->get('password')));
        if ($request->is('api/*')) {
            $vendedores=User::where('empresa_id', auth('api')->user()->empresa_id)->with(['roles'])->orderBy('nombre')->get();
            return response()->json(compact('vendedores'));
        }
        if (Auth::user()->hasRole('SuperAdministrador')) {
            return redirect('empresa/'.$usuario->empresa_id);
        }
        return redirect('e/usuario');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $usuario = User::find($id);
        $tiposVisita = TipoVisita::where('empresa_id', 0)->orWhere('empresa_id', Auth::user()->empresa_id)->orderBy('tipo')->get()->pluck('tipo', 'id');
        $tiempoVisita=['10'=>'10 minutos','20'=>'20 minutos','30'=>'30 minutos','45'=>'45 minutos','60'=>'1 hora','90'=>'1 hora y 30 minutos','120'=>'2 horas','180'=>'3 horas','240'=>'4 horas'];
        $usuario_id=$usuario->id;
        $visitasSemana = Visita::whereBetween('fecha_inicio', [Carbon::now()->subDays(7)->toDateString().' 00:00:00',Carbon::now()->toDateString().' 23:59:59'])
                            ->where('usuario_id', $id)
                            ->orderBy('fecha_inicio', 'desc')->paginate(50);
        $visitasTotal = Visita::orderBy('fecha_inicio', 'desc')->where('usuario_id', $id)->paginate(50);
        $visitasTerminadas = Visita::whereIn('estado_visita_id', [5])->where('usuario_id', $id)->orderBy('fecha_inicio', 'desc')->get()->count();
        $clientes = $usuario->clientes()->paginate(10);
        $pest=($request->has('pest'))?$request->get('pest'):'C';
        return view('usuario.show', compact('usuario', 'tiposVisita', 'tiempoVisita', 'usuario_id', 'visitasSemana', 'visitasTotal', 'visitasTerminadas', 'pest', 'clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa =Empresa::find(Auth::user()->empresa_id);
        ;
        $usuario = User::find($id);
        if (Auth::user()->hasRole('SuperAdministrador')) {
            $roles = Role::orderBy('name')->whereNotIn('name', ['SuperAdministrador'])->get()->pluck('name', 'name');
        } elseif (Auth::user()->hasRole('Administrador')) {
            $roles = Role::orderBy('name')->whereNotIn('name', ['SuperAdministrador'])->get()->pluck('name', 'name');
        } else {
            $roles = Role::orderBy('name')->whereNotIn('name', ['SuperAdministrador','Administrador'])->get()->pluck('name', 'name');
        }
        return view('usuario.form', compact('empresa', 'id', 'usuario', 'roles'));
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
        $usuario = User::find($id);
        $usuario->update($request->except(['foto','password']));
        if ($request->has('foto')) {
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        if ($request->has('password') && $request->get('password')!=null) {
            $usuario->password=bcrypt($request->get('password'));
            $usuario->save();
        }
        if ($request->has('role')) {
            $usuario->syncRoles($request->get('role'));
        }
        if (Auth::user()->id==$id) {
            $usuario->primer_login=0;
            $usuario->save();
        }
        if ($request->is('api/*')) {
            $vendedores=User::where('empresa_id', auth('api')->user()->empresa_id)->with(['roles'])->orderBy('nombre')->get();
            return response()->json(compact('vendedores', 'exito'));
        }
        if (Auth::user()->hasRole('SuperAdministrador')) {
            return redirect('empresa/'.$usuario->empresa_id);
        }
        return redirect('e/usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id)->delete();
        if ($request->is('api/*')) {
            $exito=true;
            $vendedores=User::where('empresa_id', auth('api')->user()->empresa_id)->get();
            return response()->json(compact('vendedores', 'exito'));
        }
        if (Auth::user()->hasRole('SuperAdministrador')) {
            return redirect('usuario');
        }
        return redirect('e/usuario');
    }
    public function restaurar($id)
    {
        $user = User::where('id', $id)->onlyTrashed()->first()->restore();
        if (Auth::user()->hasRole('SuperAdministrador')) {
            return redirect('usuario');
        }
        return redirect('e/usuario');
    }

    public function roles()
    {
        return Role::orderBy('name')->where('name', '!=', 'SuperAdministrador')->get();
    }

    public function asignar()
    {
        $usuarios = User::role('Vendedor')->where('empresa_id', Auth::user()->empresa_id)->paginate(50);
        return view('usuario.index', compact('usuarios'));
    }

    public function asignarme($id)
    {
        $user = User::find($id);
        $user->user_id=Auth::user()->id;
        $user->save();
        return redirect('e/usuario')->with('mensaje', 'Usuario asignado!');
    }
}
