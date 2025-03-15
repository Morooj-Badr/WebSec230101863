@extends('layouts.master')
@section('title', 'Add Products')

@section('content')
<form action="{{route('products_save', $product->id)}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="row mb-2">
        <div class="col-6">
            <label for="code" class="form-label">Code:</label>
            <input type="text" class="form-control" placeholder="Code" name="code" required value="{{$product->code}}">
        </div>
        <div class="col-6">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control" placeholder="Model" name="model" required value="{{$product->model}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="name" class="form-label">Name:</label>
            <input type="text" class="form-control" placeholder="Name" name="name" required value="{{$product->name}}">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col-6">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control" placeholder="Price" name="price" required value="{{$product->price}}">
        </div>
        <div class="col-6">
            <label for="photo" class="form-label">Photo:</label>
            <input type="file" class="form-control" name="photo">
        </div>
    </div>

    <div class="row mb-2">
        <div class="col">
            <label for="description" class="form-label">Description:</label>
            <textarea class="form-control" placeholder="Description" name="description" required>{{$product->description}}</textarea>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@if($product->photo)
<div class="mt-3">
    <h5>Current Product Image:</h5>
    <img src="{{ asset('images/' . $product->photo) }}" alt="Product Image" width="200">
</div>
@endif
@endsection
