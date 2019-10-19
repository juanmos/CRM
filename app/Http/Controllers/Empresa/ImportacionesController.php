<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ClientesImport;
use App\Imports\UsuariosImport;
use Maatwebsite\Excel\Facades\Excel;


class ImportacionesController extends Controller
{
    public function index(){
        return view('importacion.index');
    }

    public function cargar($tipo){
        return view('importacion.clientes',compact('tipo'));
    }

    public function import(Request $request) 
    {
        if($request->get('tipo')=='clientes'){
            Excel::import(new ClientesImport, $request->file('archivo'));
            return redirect('/cliente')->with('mensaje', 'Clientes cargados con exito!');
        }else{
            Excel::import(new UsuariosImport, $request->file('archivo'));
            return redirect()->route('empresa.usuario.index')->with('mensaje', 'Usuarios cargados con exito!');
        }
        
    }
}
