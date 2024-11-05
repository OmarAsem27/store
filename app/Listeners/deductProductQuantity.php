<?php

namespace App\Listeners;

use App\Facades\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

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
    public function handle($order, $user = null): void
    {
        // foreach (Cart::get() as $item) {
        //     Product::whereId($item->product_id)
        //         ->update(['quantity' => DB::raw("quantity - {$item->quantity}")]);
        // }
        dd($order->products);
        foreach ($order->products as $product) {
            $product->decrement($product->order_item->quantity);
        }
    }
}
