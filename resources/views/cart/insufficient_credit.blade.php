
@extends('layouts.master')
@section('title', 'Your Cart')

@section('content')
    <div class="alert alert-danger">
        <h3>Insufficient Credit</h3>
        <p>Your current credit is insufficient to complete the purchase. Please add more funds to your account.</p>
        <a href="{{ route('profile') }}" class="btn btn-primary">Go to Profile</a>
    </div>
@endsection
