@extends('layouts.master')
@section('title', 'Register')
@section('content')
<form method="POST" action="{{ route('users.resetPassword') }}" class="form-group mb-2" >
    @csrf
    <label for="identifier">Enter Email or Mobile Number:</label>
    <input type="text" name="identifier" required>
    <button  type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection
