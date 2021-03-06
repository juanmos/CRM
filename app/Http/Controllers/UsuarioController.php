<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
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
        $usuarios = User::orderBy('nombre')->paginate(50);
        return view('usuario.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empresa =null;
        $usuario = null;
        $roles = Role::orderBy('name')->get()->pluck('name', 'name');
        return view('usuario.form', compact('empresa', 'usuario', 'roles'));
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
        if ($request->has('foto')) {
            $usuario->foto=$request->file('foto')->store('public/usuarios');
            $usuario->save();
        }
        $usuario->syncRoles($request->get('role'));
        return redirect('usuario');
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
        $empresa =null;
        $usuario = User::find($id);
        $roles = Role::orderBy('name')->get()->pluck('name', 'name');
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
        if ($request->has('password')) {
            $usuario->password=bcrypt($request->get('password'));
            $usuario->save();
        }
        if ($request->has('role')) {
            $usuario->syncRoles($request->get('role'));
        }
        if (Auth::user()->hasRole('SuperAdministrador')) {
            return redirect('empresa/'.$usuario->empresa_id);
        }
        return redirect('usuario');
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
