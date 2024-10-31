@if ($errors->any())
    <div class="alert alert-danger">
        <h3>Errors Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }} </li>
            @endforeach
        </ul>
    </div>

@endif


<div class="form-group">
    <x-form.input label="Product Name" role="input" name="name" class="form-control-lg" :value="$product->name" />
</div>

<div class="form-group">
    <label for="">Category</label>
    <select name="category_id" class="form-control form-select">
        <option value="">Primary Category</option>
        @foreach (App\Models\Category::all() as $category)
            {{-- <option value="{{ $category->id }}" @selected($category->category_id == $category->id)>{{ $category->name }}</option> --}}
            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <x-form.textarea label="Description" name="description" :value="$product->description" />
</div>
<div class="form-group">
    <x-form.label>Image</x-form.label>
    <x-form.input type="file" name="image" />
    @if ($product->image)
        <img src="{{ asset('storage/' . $product->image) }}" alt="" height="50px">
    @endif
</div>

<div class="form-group">
    <x-form.input label="Price" name="price" :value="$product->price" />
</div>

<div class="form-group">
    <x-form.input label="Price" name="compare_price" :value="$product->compare_price" />
</div>

<div class="form-group">
    <x-form.label>Status</x-form.label>
    <div>
        <x-form.radio name="status" :checked="$category->status" :options="['active' => 'Active', 'archived' => 'Archived', 'draft' => 'Draft']" />
    </div>
</div>

<div class="form-group">
    <x-form.input label="Tags" name="tags" :value="$tags" />
</div>


<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
    <script>
        var inputElm = document.querySelector('[name=tags]'),
            tagify = new Tagify(inputElm);
    </script>
@endpush


@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush
