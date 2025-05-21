@extends('layouts.master')
@section('title', 'Login')
@section('content')
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">
      <form action="{{ route('do_login') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
          @foreach($errors->all() as $error)
          <div class="alert alert-danger">
            <strong>Error!</strong> {{$error}}
          </div>
          @endforeach
        </div>
        <div class="form-group mb-2">
          <label for="model" class="form-label">Email:</label>
          <input type="email" class="form-control" placeholder="email" name="email" required>
        </div>
        <div class="form-group mb-2">
          <label for="model" class="form-label">Password:</label>
          <input type="password" class="form-control" placeholder="password" name="password" required>
        </div>
        <div class="form-group mb-2">
          <button type="submit" class="btn btn-primary">Login</button>
          <a href="{{ route('login_with_google') }}" class="btn btn-success">Login with Google</a>
          <a href="{{ route('login_with_facebook') }}" class="btn btn-primary">Login with Facebook</a>
        </div>
        <div class="form-group mb-2">
          <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
        </div>
        
        <!-- Admin Only Delete Button -->
        @if(auth()->user() && auth()->user()->is_admin)
        <div class="form-group mt-4">
          <form action="{{ route('delete_user', ['user_id' => auth()->user()->id]) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Account</button>
          </form>
        </div>
        @endif

      </form>
    </div>
  </div>
</div>
@endsection
