<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
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
        }else if($user->hasRole('Administrador')){
            $empresa = Empresa::find($user->empresa_id);
            return view('empresa.show',compact('empresa'));
        }
        dd('No rol');
    }

    public function panel(){
        
    }
}
