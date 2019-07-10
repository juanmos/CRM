<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PlantillaDetalle;
use App\Models\Empresa;

class Plantilla extends Model
{
    protected $fillable=['nombre','activo','empresa_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }

    public function detalles()
    {
        return $this->hasMany(PlantillaDetalle::class, 'plantilla_id');
    }

}
