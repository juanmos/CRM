<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Visita;
use Auth;
use Illuminate\Http\Request;

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
        $user = User::find(Auth::user()->id);
        if ($user->hasRole('SuperAdministrador')) {
            return redirect()->route('empresa.index');
        } elseif ($user->hasRole('Administrador') || $user->hasRole('JefeVentas')) {
            return redirect()->route('empresa.show', $user->empresa_id);
        } elseif ($user->hasRole('Vendedor')) {
            return redirect('e/visitas/vendedor/' . $user->id);
        }
        dd('No rol');
    }

    public function panel()
    {
    }
}
