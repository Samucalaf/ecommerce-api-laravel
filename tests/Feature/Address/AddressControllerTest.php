<?php

namespace Tests\Feature\Address;

use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AddressControllerTest extends TestCase
{

    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }



    public function test_criar_endereco_com_sucesso()
    {

       $response = $this->actingAs($this->user)->postJson('/api/address', [
            'owner' => 'Samuel Lafuente',
            'street' => 'Rua das Flores',
            'number' => '123',
            'complement' => 'Apto 45',
            'neighborhood' => 'Centro',
            'city' => 'São Paulo',
            'federation_unit' => 'RS',
            'zip_code' => '96854938',

        ]);
        $response->assertStatus(201);
    }

    public function test_listar_enderecos_do_usuario(){

        $response = $this->actingAs($this->user)->getJson('/api/address');
        $response->assertStatus(200);

    }

    public function test_editar_endereco_com_sucesso()
    {
        $address = Address::factory()->create([
            'owner' => 'Samuel Lafuente',
            'street' => 'Rua das Flores',
            'number' => '123',
            'complement' => 'Apto 45',
            'neighborhood' => 'Centro',
            'city' => 'São Paulo',
            'federation_unit' => 'RS',
            'zip_code' => '96854938',
            'user_id' => $this->user->id,
        ]);



        $updateResponse = $this->actingAs($this->user)->putJson("/api/address/{$address->id}", [
            'owner' => 'Samuel Lafuente Updated',
        ]);

        $updateResponse->assertStatus(200)
        ->assertJson([
            'data' => [
                'id' => $address->id,
                'owner' => 'Samuel Lafuente Updated',
            ],
        ]);

        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'owner' => 'Samuel Lafuente Updated',
        ]);
    }



}
