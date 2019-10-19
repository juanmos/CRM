<?php

namespace App\Imports;

use App\Notifications\NuevoUsuarioNotification;
use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class UsuariosImport implements  ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        if($row['vendedor_cedula']!=null){
            $usuario = User::where('cedula',$row['vendedor_cedula'])->first();
            if($usuario== null){
                if($row['vendedor_email']!=null){
                    $usuario = User::where('email',$row['vendedor_email'])->first();
                }
            }
            if($row['supervisor_cedula']!=null){
                $supervisor= User::where('cedula',$row['supervisor_cedula'])->first();
            }
            if($usuario== null){
                $usuario=User::create([
                    'nombre'=>$row['vendedor_nombre'],
                    'apellido'=>$row['vendedor_apellido'],
                    'email'=>$row['vendedor_email'],
                    'password'=>bcrypt('123456'),
                    'cedula'=>$row['vendedor_cedula'],
                    'telefono'=>$row['vendedor_telefono'],
                    'empresa_id'=>Auth::user()->empresa_id,
                    'user_id'=>($supervisor!=null)?$supervisor->id:0
                ]);
                $usuario->syncRoles($row['vendedor_rol']);
                $usuario->notify(new NuevoUsuarioNotification($usuario,'123456'));
            }
        }
    }
}
