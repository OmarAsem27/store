<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('categories.view')) {
            abort(403);
        }
        $request = request();
        $categories = Category::with('parent')
            // leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            // ->select(['categories.*', 'parents.name as parent_name'])
            // ->select('categories.*')
            // ->selectRaw('(select count(*) from products where status = 'active' AND category_id = categories.id) as products_count')
            ->withCount([
                'products' => function ($query) {
                    $query->where('status', '=', 'active');
                }
            ]) // returns the column named as the relation's name_count
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('categories.create')) {
            abort(403);
        }
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->input('name'); //from any input (get,post)
        // $request->post('name'); // from post method only
        // $request->query('name'); // from url
        // $request->all(); // return array of all input data
        // $request->only(['name', 'parent_id']);
        // $request->except(['image', 'status']);

        Gate::authorize('categories.create');
        $request->validate(Category::rules(), [
            'required' => 'This field (:attribute) must be filled',
            'name.unique' => 'This name is already exists!'
        ]);

        // request merge
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        // mass assignment
        $category = Category::create($data);

        // PRG
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (Gate::denies('categories.view')) {
            abort(403);
        }
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.update');
        try {

            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')->with('info', 'Record not found');
        }

        // select * from `categories` where `id` <> ? and (`parent_id` is null or `parent_id` <> ?)
        $parents = Category::where('id', '<>', $id)->where(function ($query) use ($id) {
            $query->whereNull('parent_id')->orWhere('parent_id', '<>', $id);
        })->get();
        // use dd() instead of get() to see the sql query written
        return view('dashboard.categories.edit', compact('category', 'parents'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // handled the gate in the authorize method in the CategoryRequest
        // $request->validate(Category::rules($id));
        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }
        // $category->fill($request->all())->save();
        $category->update($data); // fill() and save()

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }

        return redirect()->route('dashboard.categories.index')->with('success', 'Category Updated!');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');
        $category = Category::findOrFail($id);
        $category->delete();

        // Category::destroy($id);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Deleted!');

    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', ['disk' => 'public']);
        return $path;
    }


    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate(3);
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category restored!');
    }
    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category deleted forever');
    }
}
