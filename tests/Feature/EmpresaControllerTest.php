<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Empresa;

class EmpresaControllerTest extends TestCase
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
    public function testEmpresaIndex()
    {
        $response = $this->get('/empresa');
        $response->assertStatus(200);
        $response->assertViewIs('empresa.index');
        $response->assertViewHas('empresas');
    }

    /** @test */
    public function testEmpresaCreate()
    {
        $response = $this->get('/empresa/create');
        $response->assertStatus(200);
        $response->assertViewIs('empresa.form');
        $response->assertViewHasAll(['empresa', 'ciudad']);
    }

    /** @test */
    public function testEmpresaStore()
    {
        $response = $this->post('empresa', $this->empresaData());
        $response->assertStatus(302);
        $response->assertRedirect('empresa');
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
    

    private function empresaData()
    {
        return [
            'nombre'=>'Juan',
            'ruc'=>'002932039020',
            'direccion'=>'jsdfis sh isdhd',
            'telefono'=>'99as0das',
            'costo'=>30,
            'ciudad_id'=>1
        ];
    }
}
