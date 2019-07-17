<?php

use Illuminate\Database\Seeder;
use App\Models\Plantilla;
use App\Models\PlantillaDetalle;

class PlantillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plantilla1 =Plantilla::create([
            'nombre'=>'Plantilla de Pre Visita General',
            'activo'=>1,
            'empresa_id'=>0,
            'previsita'=>1
        ]);

        $plantilla2 =Plantilla::create([
            'nombre'=>'Plantilla de Visita General',
            'activo'=>1,
            'empresa_id'=>0,
            'previsita'=>0
        ]);
    }
}
