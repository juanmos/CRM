<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Cliente;

class ClienteControllerTest extends TestCase
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
    public function testClienteIndex()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/cliente');
        $response->assertStatus(200);
        $response->assertViewIs('cliente.index');
    }

    /** @test */
    public function testClienteBuscar()
    {
        $response = $this->post('cliente/buscar', ['buscar'=>'Juan']);
        $response->assertOk();
        $response->assertJsonStructure(['clientes', 'usuario_id']);
    }

    /** @test */
    public function testClienteVisitas()
    {
        $response = $this->get('cliente/visitas/1');
        $response->assertOk();
    }
    
    

    /** @test */
    public function testClienteCreate()
    {
        $response = $this->get('/cliente/create');
        $response->assertStatus(200);
        $response->assertViewIs('cliente.form');
        $response->assertViewHasAll(['cliente', 'clasificacion', 'ciudades', 'vendedores', 'paises']);
    }

    /** @test */
    public function testClienteStore()
    {
        $this->withExceptionHandling();
        $response = $this->post('cliente', $this->clienteData());
        $response->assertStatus(302);
        $cliente=Cliente::get()->last();
        $response->assertRedirect('cliente/'.$cliente->id);
    }

    /** @test */
    public function testClienteShow()
    {
        $cliente =factory(Cliente::class)->make();
        $response = $this->get('cliente/'.$cliente->id);
        $response->assertViewIs('cliente.show');
        $response->assertViewHasAll(['cliente', 'tiposVisita', 'tiempoVisita']);
    }
    

    /** @test */
    public function testEmpresaEdit()
    {
        $response = $this->get('/empresa/1/edit');
        $response->assertStatus(200);
        $response->assertViewIs('empresa.form');
        $response->assertViewHasAll(['empresa', 'ciudad']);
    }
    
    /** @test */
    public function testEmpresaUpdate()
    {
        $empresa = factory(Empresa::class)->create([]);
        $response = $this->put('empresa/'.$empresa->id, $this->empresaData());
        $response->assertStatus(302);
        $response->assertRedirect('empresa/'.$empresa->id);
        $this->assertEquals('Juan', $empresa->fresh()->nombre);
    }
    

    private function clienteData()
    {
        return [
            'nombre'=>'Juan',
            'telefono'=>'002932039020',
            'telefono_facturacion'=>'002932039020',
            'direccion'=>'002932039020',
            'email'=>'cliente@cliente.com',
            'ruc'=>'002932039020',
            'pais_id'=>1,
            'ciudad_id'=>1,
            'web'=>'jsdfis sh isdhd',
            'nombre_contacto'=>'Pedro',
            'apellido_contacto'=>'Perez',
            'emailcontacto'=>'Pedro@perez.com',
            'clasificacion_id'=>'1',
            'usuario_id'=>1,
            'ciudad_id'=>1
        ];
    }
}
