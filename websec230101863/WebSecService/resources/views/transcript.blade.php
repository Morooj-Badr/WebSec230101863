@extends('layouts.master')
@section('title', 'Transcript')
@section('content')

    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
                <h3>Student Transcript</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Course Name</th>
                            <th>Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                            <tr>
                                <td>{{ $course['name'] }}</td>
                                <td>{{ $course['grade'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection
