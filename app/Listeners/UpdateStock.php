<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product->stock >= $item->quantity) {
                $product->decrement('stock', $item->quantity);
            } else {
                throw new \Exception("Insufficient stock for product ID: {$product->id}");
            }
        }
    }
}
