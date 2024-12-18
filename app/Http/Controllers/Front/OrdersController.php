<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function show(Order $order)
    {
        $delivery = $order->delivery()->select([
            'id',
            'order_id',
            'status',
            'longitude',
            'latitude',
        ])->first();

        return view('front.orders.show', [
            'order' => $order,
            'delivery' => $delivery,
        ]);

    }
}
