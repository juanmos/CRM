<?php

namespace App\Imports;

use App\Notifications\NuevoUsuarioNotification;
use App\Models\DatosFacturacion;
use App\Models\Oficina;
use App\Models\Contacto;
use App\Models\Cliente;
use App\Models\Ciudad;
use App\Models\Pais;
use App\Models\User;
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
        $hayCliente = Cliente::whereHas('facturacion',function($query)use($row){
            $query->where('ruc',$row['ruc']);
        })->first();
        if($hayCliente==null){
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
            if($row['vendedor_cedula']!=null){
                $usuario = User::where('cedula',$row['vendedor_cedula'])->first();
                if($usuario== null){
                    if($row['vendedor_email']!=null){
                        $usuario = User::where('email',$row['vendedor_email'])->first();
                    }
                }
                if($usuario== null){
                    $usuario=User::create([
                        'nombre'=>$row['vendedor_nombre'],
                        'apellido'=>$row['vendedor_apellido'],
                        'email'=>$row['vendedor_email'],
                        'password'=>bcrypt('123456'),
                        'cedula'=>$row['vendedor_cedula'],
                        'empresa_id'=>Auth::user()->empresa_id
                    ]);
                    $usuario->syncRoles('Vendedor');
                    $usuario->notify(new NuevoUsuarioNotification($usuario,'123456'));
                }
                
                $cliente->usuario_id=$usuario->id;
                $cliente->save();
            }
        }
    }
}
