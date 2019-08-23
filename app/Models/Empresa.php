<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Configuracion;
use App\Models\Plantilla;
use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\User;

class Empresa extends Model
{
    protected $fillable=['nombre','ruc','direccion','telefono','costo','ciudad_id','activo','pruebas','fecha_inicio','fecha_fin_pruebas','usuarios_permitidos'];

    public function ciudad(){
        return $this->belongsTo(Ciudad::class,'ciudad_id');
    }

    public function usuarios(){
        return $this->hasMany(User::class,'empresa_id');
    }

    public function clientes(){
        return $this->hasMany(Cliente::class,'empresa_id');
    }

    public function configuracion(){
        return $this->hasOne(Configuracion::class,'empresa_id');
    }

    public function plantillas(){
        return $this->hasMany(Plantilla::class,'empresa_id');
    }
}
