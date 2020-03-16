<?php

namespace App\Models;

use App\Models\Empresa;
use App\Models\TipoVisita;
use Illuminate\Database\Eloquent\Model;

class TipoVisitaDuracion extends Model
{
    protected $fillable = ['tipo_visita_id', 'empresa_id', 'duracion'];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function tipoVisita()
    {
        return $this->belongsTo(TipoVisita::class, 'tipo_visita_id');
    }
}
