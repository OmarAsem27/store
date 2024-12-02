@extends('layouts.dashboard')

@section('title', 'Import Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Import Products</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.products.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-form.input label="Products Count" name="count" class="form-control-lg" />
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
@endsection
