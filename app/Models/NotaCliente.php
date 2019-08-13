<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\User;

class NotaCliente extends Model
{
    protected $fillable = ['cliente_id','nota','usuario_id'];

    public function cliente(){
        return $this->belongsto(Cliente::class,'cliente_id');
    }

    public function usuario(){
        return $this->belongsto(User::class,'usuario_id');
    }
}
