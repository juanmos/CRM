<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Visita;
use App\Models\User;

class Tarea extends Model
{
    protected $fillable=['visita_id','usuario_id','usuario_crea_id','nombre','detalle','fecha','fecha_completada','realizado'];

    public function visita(){
        return $this->belongsTo(Visita::class,'visita_id');
    }

    public function usuario(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function usuarioCrea(){
        return $this->belongsTo(User::class,'usuario_crea_id');
    }

    public function usuarios_adicionales(){
        return $this->belongsToMany(User::class,'tarea_users','tarea_id','user_id')->as('adicionales');
    }
}
