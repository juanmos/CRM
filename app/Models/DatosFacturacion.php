<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class DatosFacturacion extends Model
{
    protected $fillable=['cliente_id','nombre','direccion','telefono_facturacion','ruc','email'];

    public function cliente(){
        return $this->hasOne(Cliente::class,'cliente_id');
    }
}
