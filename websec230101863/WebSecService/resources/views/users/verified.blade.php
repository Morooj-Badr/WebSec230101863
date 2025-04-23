@extends('layouts.master')

@section('title', 'Email Verified')

@section('content')
<div class="d-flex justify-content-center">
    <div class="card m-4 col-sm-6">
        <div class="card-body">
            <div class="alert alert-success">
                <h4 class="alert-heading">Email Verified Successfully!</h4>
                <p>Your email address has been verified. You can now log in to your account.</p>
                <hr>
                <p class="mb-0">
                    <a href="{{ route('login') }}" class="btn btn-primary">Go to Login</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 