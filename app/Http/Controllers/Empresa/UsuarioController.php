<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Empresa;
use App\Models\User;
use Auth;
class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->paginate(50);
        return view('usuario.index',compact('usuarios'));
    }

    public function eliminados()
    {
        $usuarios = User::where('empresa_id',Auth::user()->empresa_id)->orderBy('nombre')->onlyTrashed()->paginate(50);
        return view('usuario.index',compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa=Empresa::find(Auth::user()->empresa_id);
        $usuario = null;
        $roles = Role::orderBy('name')->where('name','!=','SuperAdministrador')->get()->pluck('name','name');
        return view('usuario.form',compact('empresa','id','usuario','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usuario = User::create($request->except(['foto']));
        if($request->has('foto')){
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        $usuario->syncRoles($request->get('role'));
        return redirect('e/usuario');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = User::find($id);
        return view('usuario.show',compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $empresa =Empresa::find(Auth::user()->empresa_id);;
        $usuario = User::find($id);
        $roles = Role::orderBy('name')->where('name','!=','SuperAdministrador')->get()->pluck('name','name');
        return view('usuario.form',compact('empresa','id','usuario','roles'));
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
        $usuario->update($request->except(['foto']));
        if($request->has('foto')){
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        $usuario->syncRoles($request->get('role'));
        return redirect('e/usuario');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect('e/usuario');
    }
    public function restaurar($id)
    {
        $user = User::where('id',$id)->onlyTrashed()->first()->restore();
        return redirect('e/usuario');
    }
}
