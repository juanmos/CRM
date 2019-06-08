<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Ciudad;

class Oficina extends Model
{
    protected $fillable=['cliente_id','matriz','direccion','ciudad_id','latitud','longitud'];

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id');
    }
}
