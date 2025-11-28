<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\OrderCreate;
use Illuminate\Support\Facades\Mail;
class EmailUsersAboutOrderCreated implements ShouldQueue
{


    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $order = $event->order;
        $cart = $event->cart;

        $email = new OrderCreate($order);

        
        Mail::to($cart->user->email)->queue($email);
    }
}
