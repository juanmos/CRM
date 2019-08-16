<?php

namespace App\Imports;

use App\Models\Cliente;
use Maatwebsite\Excel\Concerns\ToModel;
use Auth;

class ClientesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        \Log::info($row);
        return new Cliente([
            'nombre'=>$row[0],
            'telefono'=>$row[1],
            'web'=>$row[2],
            'activo'=>1,
            'clasificacion_id'=>1,
            'empresa_id'=>Auth::user()->empresa_id
        ]);
    }
}
