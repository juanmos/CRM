<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\Plantilla;

class TipoVisita extends Model
{
    protected $fillable=['tipo','empresa_id','plantilla_pre_id','plantilla_visita_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }

    public function plantillaPre(){
        return $this->belongsTo(Plantilla::class,'plantilla_pre_id');
    }

    public function plantillaVisita(){
        return $this->belongsTo(Plantilla::class,'plantilla_visita_id');
    }
}
