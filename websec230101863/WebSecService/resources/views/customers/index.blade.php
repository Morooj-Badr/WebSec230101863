@extends('layouts.master')

@section('title', 'Customer List')

@section('content')
    <h1>Customer List</h1>

    @if($customers->isEmpty())
        <p>No customers found.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Credit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>${{ number_format($customer->credit, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
