<?php

namespace App\Http\Controllers\Empresa;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ciudad;
class VariosController extends Controller
{
    public function ciudades(){
        $ciudades = Ciudad::orderBy('ciudad')->get();
        return response()->json(compact('ciudades'));
    }
}
