@extends('layouts.master')

@section('title', 'Students')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="text-primary">Student List</h2>
    @auth
    <a href="{{ route('students.add', []) }}" class="btn btn-success">

        <i class="fas fa-plus"></i> Add Student
    </a>
    @endauth
</div>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Student Details</h5>
    </div>
    <div class="card-body">
        @if ($students->count() > 0)
            <div class="table-responsive">
                <table class="table  table-bordered">
                    <thead class="table-success">
                        <tr>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Major</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->age }}</td>
                            <td>{{ $student->major }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning text-center">
                <strong>No student data available.</strong>
            </div>
        @endif
    </div>
</div>

@endsection
