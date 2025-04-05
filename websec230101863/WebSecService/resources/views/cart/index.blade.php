@extends('layouts.master')
@section('title', 'Your Cart')
@section('content')

<h1>Your Cart</h1>

@if(session('cart'))
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach(session('cart') as $productId => $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['price'] }}</td>
                    <td>{{ $product['quantity'] }}</td>
                    <td>{{ $product['quantity'] * $product['price'] }}</td>
                    <td>
                        <a href="{{ route('cart.remove', $productId) }}" class="btn btn-danger">Remove</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
@else
    <p>Your cart is empty.</p>
@endif

@endsection
