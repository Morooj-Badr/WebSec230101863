@extends('layouts.master')

@section('title', 'Email Verification')

@section('content')
<div class="row">
    <div class="m-4 col-sm-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Email Verification</h4>
                <p class="card-text">Hello {{ $name }},</p>
                <p class="card-text">Please click the button below to verify your email address:</p>
                <a href="{{ $link }}" class="btn btn-primary">Verify Email Address</a>
                <p class="card-text mt-3">If you did not create an account, no further action is required.</p>
                <p class="card-text">This link will expire in 24 hours.</p>
            </div>
        </div>
    </div>
</div>
@endsection
