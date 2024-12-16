<?php

use App\Models\Order;
use Illuminate\Support\Facades\Broadcast;

Broadcast::routes();
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('deliveries.{order_id}', function ($user, $order_id) {
    $order = Order::findOrFail($order_id);
    return $user->id === $order->user_id;
});

