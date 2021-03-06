<?php

use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'name'=>'SuperAdministrador',
            'guard_name'=>'web'
        ]);
        DB::table('roles')->insert([
            'name'=>'Administrador',
            'guard_name'=>'web'
        ]);
        DB::table('roles')->insert([
            'name'=>'JefeVentas',
            'guard_name'=>'web'
        ]);
        DB::table('roles')->insert([
            'name'=>'Vendedor',
            'guard_name'=>'web'
        ]);
        DB::table('users')->insert([
            'nombre' => 'Juan Sebastian',
            'apellido' => 'Moscoso',
            'email' => 'juanmos@gmail.com',
            'password' => bcrypt('123456'),
            'telefono' => '0991704980',
            'cedula' => '0103086773'
        ]);
        DB::table('users')->insert([
            'nombre' => 'Juan',
            'apellido' => 'Moscoso',
            'email' => 'juan.moscoso@primme.tech',
            'password' => bcrypt('123456'),
            'telefono' => '0991704980',
            'cedula' => '0103086773',
            'empresa_id'=>1
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '1',
            'model_type' => 'App\Models\User',
            'model_id' => '1'
        ]);
        DB::table('model_has_roles')->insert([
            'role_id' => '2',
            'model_type' => 'App\Models\User',
            'model_id' => '2'
        ]);
    }
}
