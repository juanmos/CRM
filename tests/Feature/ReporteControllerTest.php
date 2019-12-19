<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Visita;
use App\Models\User;

class ReporteControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp():void
    {
        parent::setUp();
        $this->seed();
        factory(User::class)->create();
    }
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_visitas_usuarios()
    {
        $this->actingAs(User::first());
        factory(Visita::class,15)->create();
        $response = $this->get('/e/reporte/visitas');

        $response->assertStatus(200);
        $response->assertViewIs('reporte.visitas');
        $response->assertViewHasAll(['visitas','fecha_inicio','fecha_fin','estados','estado_id','cliente']);
        $response->assertViewHas('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $response->assertViewHas('fecha_fin', now()->format('Y-m-d'));
        $response->assertViewHas('estado_id', 0);
    }

    public function test_visitas_usuarios_filtrar_fechas()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first());
        factory(Visita::class,15)->create();
        $response = $this->post('/e/reporte/visitas',[
            'fecha_inicio'=>now()->subDays(5)->format('Y-m-d'),
            'fecha_fin'=>now()->addDays(5)->format('Y-m-d'),
        ]);
        $response->assertOk();
        $response->assertViewIs('reporte.visitas');
        $response->assertViewHasAll(['visitas','fecha_inicio','fecha_fin','estados','estado_id','cliente']);
        $response->assertViewHas('fecha_inicio', now()->subDays(5)->format('Y-m-d'));
        $response->assertViewHas('fecha_fin', now()->addDays(5)->format('Y-m-d'));
        $response->assertViewHas('estado_id', 0);
    }

    public function test_visitas_usuarios_filtrar_estado()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first());
        factory(Visita::class,15)->create();
        $response = $this->post('/e/reporte/visitas',[
            'fecha_inicio'=>now()->subDays(5)->format('Y-m-d'),
            'fecha_fin'=>now()->addDays(5)->format('Y-m-d'),
            'estado_id'=>1
        ]);
        $response->assertOk();
        $response->assertViewIs('reporte.visitas');
        $response->assertViewHasAll(['visitas','fecha_inicio','fecha_fin','estados','estado_id','cliente']);
        $response->assertViewHas('fecha_inicio', now()->subDays(5)->format('Y-m-d'));
        $response->assertViewHas('fecha_fin', now()->addDays(5)->format('Y-m-d'));
        $response->assertViewHas('estado_id', 1);
    }

    public function test_visitas_usuarios_filtrar_cliente()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(User::first());
        factory(Visita::class,15)->create();
        $response = $this->post('/e/reporte/visitas',[
            'fecha_inicio'=>now()->subDays(5)->format('Y-m-d'),
            'fecha_fin'=>now()->addDays(5)->format('Y-m-d'),
            'estadoIid'=>1,
            'cliente'=>'Moscoso'
        ]);
        $response->assertOk();
        $response->assertViewIs('reporte.visitas');
        $response->assertViewHasAll(['visitas','fecha_inicio','fecha_fin','estados','estado_id','cliente']);
        $response->assertViewHas('fecha_inicio', now()->subDays(5)->format('Y-m-d'));
        $response->assertViewHas('fecha_fin', now()->addDays(5)->format('Y-m-d'));
    }
}
