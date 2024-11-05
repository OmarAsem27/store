<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Throwable;

class deductProductQuantity
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
        // foreach (Cart::get() as $item) {
        //     Product::whereId($item->product_id)
        //         ->update(['quantity' => DB::raw("quantity - {$item->quantity}")]);
        // }
        // dd($order->products);
        $order = $event->order;
        // dd($order->products->count());

        try {

            foreach ($order->products as $product) {
                // dd($product->order_item->quantity);
                $product->decrement('quantity', $product->order_item->quantity);
            }
        } catch (Throwable $e) {

        }
    }
}
