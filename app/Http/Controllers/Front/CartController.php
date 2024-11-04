<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    protected $cart;

    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $repository = new CartModelRepository();
        // $repository = App::make('cart');
        // $items = $repository->get();

        // $items = $cart->get();
        // dd($cart);
        return view('front.cart', ['cart' => $this->cart]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1'
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        // $repository = new CartModelRepository();
        $cart->add($product, $request->post('quantity'));
        return redirect()->route('cart.index')->with('success', 'Product added to cart!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1'
        ]);
        $product = Product::findOrFail($request->post('product_id'));
        // $repository = new CartModelRepository();
        $cart->update($product, $request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepository $cart, string $id)
    {
        // $repository = new CartModelRepository();
        $cart->delete($id);
    }

}