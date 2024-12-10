<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveriesController extends Controller
{
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate([
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric'
        ]);

        $delivery->update(['longitude' => $request->longitude, 'latitude' => $request->latitude]);
        return $delivery;
    }

    public function show($id)
    {
        $delivery = Delivery::findOrFail($id);
        return $delivery;
    }
}
