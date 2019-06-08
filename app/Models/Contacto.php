<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Ciudad;

class Contacto extends Model
{
    protected $fillable=['cliente_id','nombre','apellido','email','telefono','extension','cargo','ciudad_id','oficina_id'];

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id');
    }
}
