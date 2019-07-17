<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TipoVisitaSeeder::class);
        $this->call(EstadoSeeder::class);
        $this->call(TipoDocumentoSeeder::class);
        $this->call(ClasificacionesSeeder::class);
        $this->call(TipoEmpresaSeeder::class);
        $this->call(CiudadSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(PlantillaSeeder::class);
    }
}
