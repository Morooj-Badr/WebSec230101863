@extends('layouts.master')

@section('title', 'Exam Result')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4 text-center">
        <h1 class="text-primary">Exam Result</h1>
        <p class="fs-4 mt-3">Your Score: <strong class="text-success">{{ $score }}</strong> / {{ $total }}</p>
        <a href="{{ route('exam.start') }}" class="btn btn-outline-primary mt-3">Take Another Exam</a>
    </div>
</div>
@endsection
