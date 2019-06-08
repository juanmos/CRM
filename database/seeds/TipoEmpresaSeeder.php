<?php

use Illuminate\Database\Seeder;

class TipoEmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_empresas')->insert([
            'tipo' => "Comercialización",
        ]);
        DB::table('tipo_empresas')->insert([
            'tipo' => "Soporte",
        ]);
        DB::table('tipo_empresas')->insert([
            'tipo' => "Servicios",
        ]);
    }
}
