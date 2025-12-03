<?php

namespace Tests\Feature\User;

use App\Events\WelcomeToNewUser;
use Illuminate\Support\Facades\Event;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class UserRoleTest extends TestCase
{
    use WithFaker, RefreshDatabase;




    public function test_dispara_evento_ao_criar_usuario()
    {
        Event::fake();


        $userData = (object) [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
        ];

        event(new WelcomeToNewUser($userData));

        Event::assertDispatched(WelcomeToNewUser::class, function ($event) use ($userData) {
            return $event->user->email === $userData->email;
        });
    }

    public function test_permissao_de_usuario()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $customer = User::factory()->create(['role' => 'customer']);

        $this->assertEquals('admin', $admin->role);
        $this->assertEquals('customer', $customer->role);
    }


    public function test_admin_pode_criar_categorias()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->postJson('/api/categories', [
                'name' => 'Test Category',
                'description' => 'Test Description',
                'slug' => 'test-category',
            ])
            ->assertStatus(201);
    }

    public function test_customer_nao_pode_criar_categorias()
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)
            ->postJson('/api/categories', [
                'name' => 'Test Category',
                'description' => 'Test Description',
                'slug' => 'test-category',
            ])
            ->assertStatus(403);
    }
}
