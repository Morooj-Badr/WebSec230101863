@extends('layouts.master')

@section('title', 'Add Student')

@section('content')

<div class="card shadow-lg mx-auto" style="max-width:600px;">
    <div class="card-header bg-success text-white text-center">
        <h4 class="mb-0">Add New Student</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('student_save') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name:</label>
                <input type="text" class="form-control" name="name" placeholder="Enter name" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="age" class="form-label fw-bold">Age:</label>
                <input type="text" class="form-control" name="age" placeholder="Enter age" required value="{{ old('age') }}">
            </div>

            <div class="mb-3">
                <label for="major" class="form-label fw-bold">Major:</label>
                <input type="text" class="form-control" name="major" placeholder="Enter major" required value="{{ old('major') }}">
            </div>

            <button type="submit" class="btn btn-success w-40">
                <i class="fas fa-plus"></i> Add Student
            </button>
        </form>
    </div>
</div>

@endsection
