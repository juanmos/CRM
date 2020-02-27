<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Contacto;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Cliente;
class ContactoControllerTest extends TestCase
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
    public function testCreateContacto()
    {
        $cliente = factory(Cliente::class)->create();
        $response = $this->get('/contacto/create/'.$cliente->id);
        $response->assertStatus(200);
        $response->assertViewIs('contacto.form');
        $response->assertViewHasAll(['contacto','cliente_id','ciudades','oficinas']);
    }

    /** @test */
    public function testStoreContacto()
    {
        $this->withoutExceptionHandling();
        $contactos=Contacto::all();
        $cliente = factory(Cliente::class)->create();
        $response = $this->post('/contacto/store/'.$cliente->id,$this->contactoData());
        $response->assertRedirect('cliente/'.$cliente->id);
        $this->assertCount(1,Contacto::all());
    }

    /** @test */
    public function testEditContacto()
    {
        $this->withoutExceptionHandling();
        $cliente = factory(Cliente::class)->create();
        $contacto = factory(Contacto::class)->create([
            'cliente_id'=>$cliente->id
        ]);
        $response = $this->get('contacto/edit/'.$contacto->id);
        $response->assertStatus(200);
        $response->assertViewIs('contacto.form');
        $response->assertViewHasAll(['contacto','ciudades','oficinas']);
    }

    /** @test */
    public function testUpdateContacto()
    {
        $this->withoutExceptionHandling();
        $cliente = factory(Cliente::class)->create();
        $contacto = factory(Contacto::class)->create([
            'cliente_id'=>$cliente->id
        ]);
        $response = $this->put('contacto/update/'.$contacto->id,$this->contactoData());
        $response->assertStatus(302);
        $response->assertRedirect('cliente/'.$cliente->id);
        $this->assertEquals('Juan',$contacto->fresh()->nombre);
    }

    /** @test */
    public function testEliminarContacto()
    {
        $cliente = factory(Cliente::class)->create();
        $contacto = factory(Contacto::class)->create([
            'cliente_id'=>$cliente->id
        ]);
        $response= $this->delete('contacto/'.$contacto->id);
        $response->assertStatus(302);
        $response->assertRedirect('cliente/'.$cliente->id);
    }


    private function contactoData(){
        return [
            'nombre'=>'Juan',
            'apellido'=>'Moscoso',
            'email'=>'juan@moscoso.com',
            'ciudad_id'=>1,
            'oficina_id'=>0
        ];
    }
}
