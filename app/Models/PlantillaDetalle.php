<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Plantilla;

class PlantillaDetalle extends Model
{
    use SoftDeletes;

    protected $fillable=['plantilla_id','label','tipo_campo','orden','valor_defecto','opciones'];

    public function plantilla(){
        return $this->belongsTo(Plantilla::class,'plantilla_id');
    }
}
