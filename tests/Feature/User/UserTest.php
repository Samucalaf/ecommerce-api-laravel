<?php

namespace Tests\Feature\User;
use App\Events\WelcomeToNewUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

use Tests\TestCase;
use User;

class UserTest extends TestCase
{


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
}
