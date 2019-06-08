<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Empresa;

class TipoVisita extends Model
{
    protected $fillable=['tipo','empresa_id'];

    public function empresa(){
        return $this->belongsTo(Empresa::class,'empresa_id');
    }
}
