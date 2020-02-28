<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Objetivo;
use App\Models\Empresa;

class ObjetivoControllerTest extends TestCase
{
    use RefreshDatabase;
    private $user;

    protected function setUp():void
    {
        parent::setUp();
        $this->seed();
        $this->user=factory(User::class)->create([
            'empresa_id'=>factory(Empresa::class)
        ]);
        $this->actingAs($this->user);
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testObjetivosIndex()
    {
        $response = $this->get('e/objetivos');
        $response->assertStatus(200);
        $response->assertViewIs('objetivo.index');
        $response->assertViewHasAll(['objetivos']);
    }

    public function testObjetivoStore()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('e/objetivos', [
            'texto'=>'Texto',
            'fecha'=>'2020-09-09',
            'porcentaje'=>50
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('e/objetivos');
        $this->assertCount(1, Objetivo::all());
    }

    public function testObjetivoUpdate()
    {
        $objetivo=factory(Objetivo::class)->create([
            'usuario_id'=>$this->user
        ]);
        $response = $this->post('e/objetivos/'.$objetivo->id, [
            'porcentaje'=>90
        ]);
        $response->assertStatus(302);
        $response->assertRedirect('e/objetivos');
        $this->assertCount(1, Objetivo::all());
        $this->assertEquals(90, $objetivo->fresh()->porcentaje);
    }
}
