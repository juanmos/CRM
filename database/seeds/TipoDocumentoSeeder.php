<?php

use Illuminate\Database\Seeder;

class TipoDocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_documentos')->insert([
            'tipo' => "Cotización",
        ]);
        DB::table('tipo_documentos')->insert([
            'tipo' => "Factura",
        ]);
        DB::table('tipo_documentos')->insert([
            'tipo' => "Retención",
        ]);
        DB::table('tipo_documentos')->insert([
            'tipo' => "Otro",
        ]);
    }
}
