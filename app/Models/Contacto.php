<?php

namespace App\Models;

use App\Models\Ciudad;
use App\Models\Cliente;
use App\Models\Oficina;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contacto extends Model
{
    use SoftDeletes;

    protected $fillable = ['cliente_id', 'nombre', 'apellido', 'email', 'telefono', 'extension', 'cargo', 'ciudad_id', 'oficina_id'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudad::class, 'ciudad_id');
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'oficina_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function getNameCargoAttribute()
    {
        return "{$this->nombre} {$this->apellido} - {$this->cargo}";
    }
}
