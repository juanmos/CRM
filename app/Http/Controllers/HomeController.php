<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Visita;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user= User::find(Auth::user()->id);
        if($user->hasRole('SuperAdministrador')){
            return view('admin.panel');
        }else if(!$user->hasRole('SuperAdministrador')){
            $empresa = Empresa::find($user->empresa_id);
            $clientes = Cliente::where('empresa_id',$user->empresa_id)->get();
            $visitas = Visita::whereHas('cliente',function($query) use($clientes){
                $query->whereIn('cliente_id',$clientes->pluck('id'));
            })->get()->count();
            $visitasTerminadas = Visita::whereHas('cliente',function($query) use($clientes){
                $query->whereIn('cliente_id',$clientes->pluck('id'));
            })->where('estado_visita_id',5)->get()->count();
            if(Auth::user()->hasRole('Administrador')){
                $usuarios=$empresa->usuarios;
            }elseif(Auth::user()->hasRole('JefeVentas')){
                $usuarios=User::where('empresa_id',$user->empresa_id)->where('user_id',$user->id)->get();
                $usuarios->push($user);
            }else{
                $usuarios=User::where('id',$user->id)->get();
            }
            
            return view('empresa.show',compact('empresa','visitas','visitasTerminadas','clientes','usuarios'));
            
        }
        dd('No rol');
    }

    public function panel(){
        
    }
}
