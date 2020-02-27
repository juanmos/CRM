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
    protected function setUp():void
    {
        parent::setUp();
        $this->seed();
        $user=factory(User::class)->create([
            'empresa_id'=>factory(Empresa::class)
        ]);
        $this->actingAs($user);
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
}
