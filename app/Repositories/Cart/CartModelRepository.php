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
    public function get(): Collection
    {
        return Cart::with('product')->get();
        // return Cart::with('product')->where('cookie_id', '=', $this->getCookieId())->get();
    }

    public function add(Product $product, $quantity = 1)
    {
        $item = Cart::where('product_id', '=', $product->id)
            ->first();
        // dd($cart);
        if ($item) {
            $item->increment('quantity', $quantity);
        } else {
            return Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }
    }

    public function update(Product $product, $quantity)
    {
        Cart::where('product_id', '=', $product->id)
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
        return (float) Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) AS total')
            ->value('total');
    }

    // protected function getCookieId()
    // {
    //     $cookie_id = Cookie::get('cart_id');
    //     if (!$cookie_id) {
    //         $cookie_id = Str::uuid();
    //         Cookie::queue('cart_id', $cookie_id, 30 * 24 * 60);
    //     }
    //     return $cookie_id;
    // }


}
