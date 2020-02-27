<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Configuracion;
class ConfiguracionControllerTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp():void
    {
        parent::setUp();
        $this->seed();
        factory(User::class)->create();
        $this->actingAs(User::first());
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRutasNoAutorizadas()
    {
        $response = $this->get('/configuracion');
        $response->assertUnauthorized();
        $response = $this->post('/configuracion');
        $response->assertUnauthorized();
        $response = $this->get('/configuracion/1');
        $response->assertUnauthorized();
    }

    /** @test */
    public function testEditConfiguracion()
    {
        $configuracion = factory(Configuracion::class)->create();
        $response = $this->get('/configuracion/'.$configuracion->id.'/edit');
        $response->assertOk();
        $response->assertViewIs('empresa.configuracion');
        $response->assertViewHasAll(['configuracion','horaInicial','horaFinal','vistaAgenda','tiempoVisita']);
    }

    /** @test */
    public function testUpdateConfiguracion()
    {
        $configuracion = factory(Configuracion::class)->create();
        $response = $this->put('/configuracion/'.$configuracion->id,[
            'min_time'=>'09:00',
            'max_time'=>'21:00',
            'scrollTime'=>'30',
        ]);
        $response->assertStatus(302);
        $this->assertEquals('09:00',$configuracion->fresh()->min_time);
    }


}
