<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\DatosFacturacion;
use App\Models\Clasificacion;
use App\Models\Contacto;
use App\Models\Oficina;
use App\Models\Empresa;
use App\Models\User;

class Cliente extends Model
{
    use SoftDeletes;
    protected $fillable=['nombre','telefono','web','activo','clasificacion_id','usuario_id','empresa_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }

    public function clasificacion(){
        return $this->belongsTo(Clasificacion::class,'clasificacion_id');
    }

    public function vendedor(){
        return $this->belongsTo(User::class,'usuario_id');
    }

    public function facturacion(){
        return $this->hasOne(DatosFacturacion::class,'cliente_id');
    }

    public function contactos(){
        return $this->hasMany(Contacto::class,'cliente_id');
    }

    public function oficinas(){
        return $this->hasMany(Oficina::class,'cliente_id');
    }
}
