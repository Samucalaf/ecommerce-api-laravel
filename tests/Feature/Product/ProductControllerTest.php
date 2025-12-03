<?php

namespace Tests\Feature\Product;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Category $category;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'role' => 'admin',
        ]);
        $this->category = Category::factory()->create();

        $this->product = Product::factory()->create([
            'category_id' => $this->category->id,
        ]);
    }


    public function test_usuario_pode_criar_produto()
    {


        $response = $this->actingAs($this->user)->postJson('/api/products', [
            'name' => 'Produto Teste',
            'description' => 'Descrição do Produto Teste',
            'price' => 99.99,
            'slug' => 'produto-teste',
            'specifications' => ['Especificações do Produto Teste'],
            'stock' => 50,
            'category_id' => $this->category->id,
        ]);


        $response->assertStatus(201);
    }

    public function test_usuario_pode_atualizar_produto()
    {
        $response = $this->actingAs($this->user)->putJson("/api/products/{$this->product->id}", [
            'name' => 'Produto Atualizado',
            'description' => 'Descrição do Produto Atualizado',
            'price' => 149.99,
            'slug' => 'produto-atualizado',
            'specifications' => ['Especificações do Produto Atualizado'],
            'stock' => 30,
            'category_id' => $this->category->id,
        ]);

        $response->assertStatus(200);
    }

    public function test_usuario_pode_deletar_produto()
    {
        // Coloca o produto com stock 0 antes de deletar
        $this->product->update(['stock' => 0]);

        $response = $this->actingAs($this->user, 'sanctum')->deleteJson("/api/products/{$this->product->id}");

        $response->assertStatus(200);
    }
}
