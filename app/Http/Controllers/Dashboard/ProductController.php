<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Product::class); // takes the function name of the policy

        // if (Auth::user()->store_id) {
        //     $products = Product::where('store_id', Auth::user()->store_id)->paginate();
        // } else {
        //     $products = Product::paginate();
        // }
        $products = Product::with(['category', 'store'])->paginate();

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Product::class); // takes the function name of the policy
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Product::class); // takes the function name of the policy
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('view', $product); // takes the function name of the policy
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product); // takes the function name of the policy

        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit', compact('product', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('update', $product); // takes the function name of the policy

        $product->update($request->except('tags'));
        $tags = json_decode($request->post('tags'));
        // dd(json_decode($request->post('tags')));
        $tag_ids = [];
        $saved_tags = Tag::all();
        foreach ($tags as $t_name) {
            // dd($t_name->value);
            $slug = Str::slug($t_name->value);
            // $tag = Tag::where('slug', $slug)->first();
            $tag = $saved_tags->where('slug', $slug)->first(); // better than searching in DB inside the loop
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $t_name->value,
                    'slug' => $slug
                ]);
            }
            $tag_ids[] = $tag->id;
        }
        $product->tags()->sync($tag_ids);

        return redirect()->route('dashboard.products.index')->with('success', 'Product Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        Gate::authorize('update', $product); // takes the function name of the policy
    }
}
