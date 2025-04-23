@extends('layouts.master')
@section('title', 'Forgot Password')
@section('content')
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">
      <h4 class="card-title mb-4">Reset Password</h4>
      <form action="{{ route('password.email') }}" method="post">
        @csrf
        <div class="form-group">
          @if (session('status'))
            <div class="alert alert-success">
              {{ session('status') }}
            </div>
          @endif
          @foreach($errors->all() as $error)
            <div class="alert alert-danger">
              <strong>Error!</strong> {{$error}}
            </div>
          @endforeach
        </div>
        <div class="form-group mb-2">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
        </div>
        <div class="form-group mb-2">
          <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection 