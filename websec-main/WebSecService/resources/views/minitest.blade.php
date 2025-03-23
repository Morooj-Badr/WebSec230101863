@extends('layouts.master')
@section('title', 'Mini Test')
@section('content')
<div class="container" >
    <h2 class="text-center">Supermarket Bill</h2>
    <table class="table table-bordered">
        <thead>
            <tr class="table-warning">
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($bill as $item)
                <tr class="table-light">
                    <td>{{ $item['item'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ $item['price'] }}</td>
                </tr>
                @php $total += $item['price']; @endphp
            @endforeach
            <tr class="table-success">
                <td colspan="2" class="text-end"><strong>Total:</strong></td>
                <td><strong>${{ $total }}</strong></td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

