@extends('layouts.dashboard')

@section('title', 'Roles')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Roles</li>
@endsection

@section('content')

    <form action="{{ route('dashboard.roles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.roles._form')
    </form>
@endsection
