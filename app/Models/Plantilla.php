<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PlantillaDetalle;
use App\Models\TipoVisita;
use App\Models\Empresa;

class Plantilla extends Model
{
    protected $fillable=['nombre','activo','empresa_id','previsita'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }

    public function detalles()
    {
        return $this->hasMany(PlantillaDetalle::class, 'plantilla_id');
    }

    public function tipos(){
        return $this->hasMany(TipoVisita::class,'plantilla_id');
    }

}
