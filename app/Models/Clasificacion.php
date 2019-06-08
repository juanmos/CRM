<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class Clasificacion extends Model
{
    protected $fillable=['clasificacion','empresa_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }
}
