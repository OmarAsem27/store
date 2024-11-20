@extends('layouts.dashboard')

@section('title', $role->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
    <li class="breadcrumb-item active">{{ $role->name }}</li>
@endsection

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Product Name</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>


@endsection
