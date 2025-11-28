<?php

namespace App\Listeners;

use App\Events\WelcomeToNewUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\WelcomeUser;
use Illuminate\Support\Facades\Mail;
class EmailAboutNewUserCreated implements ShouldQueue
{


    /**
     * Handle the event.
     */
    public function handle(WelcomeToNewUser $event): void
    {
        $user = $event->user;

        $email = new WelcomeUser($user);

        Mail::to($user->email)->later(now()->addSeconds(15), $email);
    }
}
