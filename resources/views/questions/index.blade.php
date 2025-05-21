@extends('layouts.master')
@section('title', 'questions')
@section('content')
    <h1>Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-success">Add New Question</a>

    @foreach($questions as $question)
        <div class="card mt-3">
            <div class="card-body">
                <p><strong>{{ $question->question }}</strong></p>
                <p>A) {{ $question->option_a }}</p>
                <p>B) {{ $question->option_b }}</p>
                <p>C) {{ $question->option_c }}</p>
                <p>D) {{ $question->option_d }}</p>
                <a href="{{ route('questions.edit', $question) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
@endsection
