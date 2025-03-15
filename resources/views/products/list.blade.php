@extends('layouts.master')
@section('title', ' Products')
@section('content')
<br>
<div class="row mt-2">
    <div class="col col-10">
        <h1>Products</h1>
    </div>
    <div class="col col-2">
    @auth
        <a href="{{route('products_edit')}}" class="btn btn-success form-control">Add Product</a>
    @endauth
    </div>
</div>
<div class="container">
    <form>
        <div class="row">
            <div class="col col-sm-2">
                <input name="keywords" type="text" class="form-control" placeholder="Search Keywords" value="{{ request()->keywords }}" />
            </div>
            <div class="col col-sm-2">
                <input name="min_price" type="numeric" class="form-control" placeholder="Min Price" value="{{ request()->min_price }}"/>
            </div>
            <div class="col col-sm-2">
                <input name="max_price" type="numeric" class="form-control" placeholder="Max Price" value="{{ request()->max_price }}"/>
            </div>
            <div class="col col-sm-2">
                <select name="order_by" class="form-select">
                    <option value="" {{ request()->order_by==""?"selected":"" }} disabled>Order By</option>
                    <option value="name" {{ request()->order_by=="name"?"selected":"" }}>Name</option>
                    <option value="price" {{ request()->order_by=="price"?"selected":"" }}>Price</option>
                </select>
            </div>
            <div class="col col-sm-2">
                <select name="order_direction" class="form-select">
                    <option value="" {{ request()->order_direction==""?"selected":"" }} disabled>Order Direction</option>
                    <option value="ASC" {{ request()->order_direction=="ASC"?"selected":"" }}>ASC</option>
                    <option value="DESC" {{ request()->order_direction=="DESC"?"selected":"" }}>DESC</option>
                </select>
            </div>
            <div class="col col-sm-1">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="col col-sm-1">
            <a href="{{ url('./products') }}" class="btn btn-danger">Reset</a>

                
            </div>
        </div>
    </form> 
        
    <br>
@foreach($products as $product)
<div class="row mb-2 align-items-center">
    <div class="col-8">
        <h3>{{$product->name}}</h3>
    </div>
    <div class="col-4 text-end">
        <a href="{{route('products_edit', $product->id)}}" class="btn btn-success">Edit</a>
        <a href="{{route('products_delete', $product->id)}}" class="btn btn-danger">Delete</a>
    </div>
</div>    

    
<div class="card mt-2">
    <div class="card-body">
        <div class="row">
            <div class="col col-sm-12 col-lg-4">
            <img src="{{ asset(Str::startsWith($product->photo, 'uploads/') ? $product->photo : 'uploads/' . $product->photo) }}"
     class="img-thumbnail" alt="{{ $product->name }}" width="100%">


                </div>
                <div class="col col-sm-12 col-lg-8 mt-3">
                <h3>{{$product->name}}</h3>
                <table class="table table-striped">
                <tr><th width="20%">Name</th><td>{{$product->name}}</td></tr>
                <tr><th>Model</th><td>{{$product->model}}</td></tr>
                <tr><th>Code</th><td>{{$product->code}}</td></tr>
                <tr><th>Description</th><td>{{$product->description}}</td></tr>
                <tr><th>Price</th><td>{{$product->price}}</td></tr>
                </table>
            </div>
        </div>
    </div>

@endforeach
@endsection