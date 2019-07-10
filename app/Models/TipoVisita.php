<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;
use App\Models\Plantilla;

class TipoVisita extends Model
{
    protected $fillable=['tipo','empresa_id','plantilla_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }

    public function plantilla(){
        return $this->belongsTo(Plantilla::class,'plantilla_id');
    }
}
