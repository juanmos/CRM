<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\NotaCliente;
use App\Models\User;
use App\Models\Empresa;

class NotaControllerTest extends TestCase
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
    public function testNotasIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
