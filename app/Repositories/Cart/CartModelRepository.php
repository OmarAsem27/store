<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{

    protected $items;
    public function __construct()
    {
        $this->items = collect([]);
    }
    public function get(): Collection
    {
        if (!$this->items->count()) {
            $this->items = Cart::with('product')->get();
        }
        return $this->items;

        // return Cart::with('product')->where('cookie_id', '=', $this->getCookieId())->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        // $item = Cart::where('product_id', '=', $product->id)
        //     ->first();
        // // dd($cart);
        // if ($item) {
        //     $item->increment('quantity', $quantity);
        // } else {
        //     return Cart::create([
        //         'user_id' => Auth::id(),
        //         'product_id' => $product->id,
        //         'quantity' => $quantity
        //     ]);
        // }
        // return $item->increment('quantity', $quantity);
        $item = Cart::where('product_id', '=', $product->id)
            ->first();
        if (!$item) {
            $cart = Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
            return $this->get()->push($cart);
        }
        return $item->increment('quantity', $quantity);
    }

    public function update($id, $quantity)
    {
        Cart::where('id', '=', $id)
            ->update(['quantity' => $quantity]);
    }

    public function delete($id)
    {
        Cart::where('id', '=', $id)
            ->delete();
    }

    public function empty()
    {
        Cart::query()->delete();
    }

    public function total(): float
    {
        // return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
        //     ->selectRaw('SUM(products.price * carts.quantity) AS total')
        //     ->value('total');

        return $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }




}