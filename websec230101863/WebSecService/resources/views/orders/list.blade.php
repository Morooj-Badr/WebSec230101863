@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Your Orders</h2>

    <!-- ✅ Success Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- ✅ Orders Table -->
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Status</th>
                <th>Purchase Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->product->name }}</td>
                    <td>${{ number_format($order->total_price, 2) }}</td>
                    <td>
                        <span class="badge 
                            {{ $order->status == 'completed' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d M Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
