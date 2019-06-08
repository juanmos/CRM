<?php

use Illuminate\Database\Seeder;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'nombre' => "Centuriosa",
            'ruc'=>'00000000',
            'direccion'=>'Viuda de pareja',
            'telefono'=>'04284838',
            'costo'=>0,
            'ciudad_id'=>1
        ]);
    }
}
