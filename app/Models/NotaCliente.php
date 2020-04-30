<?php

namespace App\Models;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class NotaCliente extends Model
{
    protected $fillable = ['cliente_id', 'nota', 'usuario_id'];

    public function cliente()
    {
        return $this->belongsto(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsto(User::class, 'usuario_id');
    }
}
