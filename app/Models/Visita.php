<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contacto;
use App\Models\Cliente;
use App\Models\TipoVisita;
use App\Models\EstadoVisita;
use App\Models\User;

class Visita extends Model
{
    use SoftDeletes;
    protected $fillable=['cliente_id','usuario_id','contacto_id','tipo_visita_id','estado_visita_id','fecha_inicio','fecha_fin','codigo','descripcion'];

    public function vendedor(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function contacto(){
        return $this->belongsTo(Contacto::class,'contacto_id');
    }

    public function tipoVisita(){
        return $this->belongsTo(TipoVisita::class,'tipo_visita_id');
    }

    public function estado(){
        return $this->belongsTo(EstadoVisita::class,'estado_visita_id');
    }
}