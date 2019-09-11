<?php

namespace App\Imports;

use App\Models\DatosFacturacion;
use App\Models\Oficina;
use App\Models\Contacto;
use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Pais;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class ClientesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        
        $cliente= Cliente::create([
            'nombre'=>$row['empresa'],
            'telefono'=>$row['telefono'],
            'web'=>$row['web'],
            'activo'=>1,
            'clasificacion_id'=>1,
            'empresa_id'=>Auth::user()->empresa_id
        ]);
        $fac = DatosFacturacion::create([
            'cliente_id'=>$cliente->id,
            'nombre'=>$row['empresa'],
            'direccion'=>$row['direccion'],
            'telefono_facturacion'=>$row['telefono'],
            'ruc'=>$row['ruc'],
            'email'=>$row['email'],
        ]);
        $pais=Pais::where('pais',$row['pais'])->first();
        $pais_id=($pais==null)?1:$pais->id;
        $ciudad = Ciudad::where('ciudad',$row['ciudad'])->where('pais_id',$pais_id)->first();
        $ciudad_id=($ciudad==null)?1:$ciudad->id;
        $oficina=Oficina::create([
            'cliente_id'=>$cliente->id,
            'matriz'=>1,
            'direccion'=>$row['direccion'],
            'ciudad_id'=>$ciudad_id,
            'pais_id'=>$pais_id,
            'latitud'=>0,
            'longitud'=>0
        ]);
        if($row['nombre_contacto']!=null && $row['apellido_contacto']!=null){
            Contacto::create([
                'cliente_id'=>$cliente->id,
                'nombre'=>$row['nombre_contacto'],
                'apellido'=>$row['apellido_contacto'],
                'email'=>$row['email_contacto'],
                'telefono'=>$row['telefono_contacto'],
                'extension'=>$row['extension'],
                'cargo'=>$row['cargo'],
                'ciudad_id'=>$ciudad_id,
                'oficina_id'=>$oficina->id
            ]);
        }
    }
}
