<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
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
    public function testUserIndex()
    {
        $response = $this->get('/usuario');
        $response->assertStatus(200);
        $response->assertViewIs('usuario.index');
        $response->assertViewHas('usuarios');
    }

    /** @test */
    public function testUserCreate()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/usuario/create');
        $response->assertStatus(200);
        $response->assertViewIs('usuario.form');
        $response->assertViewHasAll(['empresa', 'usuario', 'roles']);
    }

    /** @test */
    public function testUserStore()
    {
        $response = $this->post('usuario', $this->userData());
        $response->assertStatus(302);
        $response->assertRedirect('usuario');
    }

    /** @test */
    public function testUserEdit()
    {
        $response = $this->get('/usuario/1/edit');
        $response->assertStatus(200);
        $response->assertViewIs('usuario.form');
        $response->assertViewHasAll(['empresa', 'usuario', 'roles']);
    }
    
    /** @test */
    public function testUserUpdate()
    {
        $user = factory(User::class)->create(['empresa_id'=>1]);
        $response = $this->put('usuario/'.$user->id, $this->userData());
        $response->assertStatus(302);
        $response->assertRedirect('empresa/1');
        $this->assertEquals('Juan', $user->fresh()->nombre);
    }
    

    private function userData()
    {
        return [
            'nombre'=>'Juan',
            'apellido'=>'Moscoso',
             'email'=>'juan@juan.com',
             'password'=>'123456',
             'telefono'=>'0394039439'
        ];
    }
}
