@extends('layouts.master')

@section('title', 'Exams')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Start Exam</h1>
    <div class="card shadow-lg p-4">
        <form method="POST" action="{{ route('exam.submit') }}">
            @csrf
            @foreach($questions as $question)
                <div class="mb-4">
                    <h4 class="fw-bold">{{ $question->question_text }}</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="A" id="q{{ $question->id }}a">
                        <label class="form-check-label" for="q{{ $question->id }}a">
                            {{ $question->option_a }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="B" id="q{{ $question->id }}b">
                        <label class="form-check-label" for="q{{ $question->id }}b">
                            {{ $question->option_b }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="C" id="q{{ $question->id }}c">
                        <label class="form-check-label" for="q{{ $question->id }}c">
                            {{ $question->option_c }}
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="D" id="q{{ $question->id }}d">
                        <label class="form-check-label" for="q{{ $question->id }}d">
                            {{ $question->option_d }}
                        </label>
                    </div>
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary w-100">Submit Exam</button>
        </form>
    </div>
</div>
@endsection
