<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Plantilla;
use App\Models\Visita;

class PlantillaDetalle extends Model
{
    use SoftDeletes;

    protected $fillable=['plantilla_id','label','tipo_campo','orden','valor_defecto','opciones'];

    public function plantilla(){
        return $this->belongsTo(Plantilla::class,'plantilla_id');
    }

    public function visita()
    {
        return $this->belongsToMany(Visita::class,'plantilla_detalles_visitas','plantilla_detalle_id','visita_id')->as('respuestas')->withPivot('valor');
    }
}
