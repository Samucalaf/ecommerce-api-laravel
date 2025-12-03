<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class AuthenticationTest extends TestCase
{

    use RefreshDatabase;
    public function test_user_pode_registrar()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);


        $response->assertStatus(201);
    }


    public function test_user_pode_fazer_login()
    {
        // Primeiro, registrar um usuário para fazer login
        $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'password123',
        ])->assertStatus(200);
    }


    public function test_user_nao_pode_fazer_login_com_credenciais_invalidas()
    {
        $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'wrongpassword',
        ])->assertStatus(401);
    }


    public function test_user_nao_pode_registrar_com_email_existente()
    {
        $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertStatus(422);
    }

    public function test_user_nao_pode_registrar_com_senha_curta()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'usuarioTeste@gmail.com',
            'password' => 'short',
            'password_confirmation' => 'short',
            'role' => 'admin',
        ]);

        $response->assertStatus(422);
    }


    public function test_user_nao_pode_registrar_com_email_invalido()
    {
        $response = $this->postJson('/api/auth/register', [
            'name' => 'Test User',
            'email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
        ]);

        $response->assertStatus(422);
    }
}
