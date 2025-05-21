@extends('layouts.master')

@section('title', 'Add Credit')

@section('content')
    <h1>Add Credit</h1>
    
    <form method="POST" action="{{ route('submit_add_credit') }}">
        @csrf
        <div class="form-group">
            <label for="amount">Amount to Add</label>
            <input type="number" name="amount" id="amount" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Add Credit</button>
    </form>
    
    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif
@endsection
