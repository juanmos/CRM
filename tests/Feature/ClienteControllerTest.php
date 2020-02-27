<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Configuracion;
use App\Models\DatosFacturacion;
use TipoVisitaSeeder;

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

        $this->seed(TipoVisitaSeeder::class);
        $empresa=factory(Empresa::class)->create();
        factory(Configuracion::class)->create([
            'empresa_id'=>$empresa->id
        ]);
        $usuario=factory(User::class)->create([
            'empresa_id'=>$empresa->id
        ]);
        $this->actingAs($usuario);

        $cliente =factory(Cliente::class)->create([
            'usuario_id'=>$usuario->id,
            'empresa_id'=>$empresa->id
        ]);
        factory(DatosFacturacion::class)->create([
            'cliente_id'=>$cliente->id
        ]);
        // $cliente->empresa()->usuarios()
        $response = $this->get('cliente/'.$cliente->id.'/ver');
        $response->assertViewIs('cliente.show');
        $response->assertViewHasAll(['cliente', 'tiposVisita', 'tiempoVisita']);
    }


    /** @test */
    public function testClienteEdit()
    {

        $cliente =factory(Cliente::class)->create();
        factory(DatosFacturacion::class)->create([
            'cliente_id'=>$cliente->id
        ]);
        $response = $this->get('/cliente/'.$cliente->id.'/edit');
        $response->assertStatus(200);
        $response->assertViewIs('cliente.form');
        $response->assertViewHasAll(['cliente', 'clasificacion', 'ciudades', 'vendedores', 'paises']);
    }

    /** @test */
    public function testClienteUpdate()
    {
        $this->withoutExceptionHandling();
        $cliente =factory(Cliente::class)->create();
        factory(DatosFacturacion::class)->create([
            'cliente_id'=>$cliente->id
        ]);
        $response = $this->put('cliente/'.$cliente->id, $this->clienteData());
        $response->assertStatus(302);
        $response->assertRedirect('cliente/');
        $this->assertEquals('Juan', $cliente->fresh()->nombre);
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
