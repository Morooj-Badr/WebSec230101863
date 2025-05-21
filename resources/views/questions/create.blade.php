@extends('layouts.master')

@section('title', 'Add Question')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h1 class="text-primary text-center">Add New Question</h1>

        <form method="POST" action="{{ route('questions.store') }}">
            @csrf
            <div class="mb-3">
            <label  class="form-label">Question</label>
            <input type="text" name="question_text"class="form-control" required>

            </div>

            <div class="mb-3">
                <label class="form-label">Option A</label>
                <input type="text" name="option_a" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option B</label>
                <input type="text" name="option_b" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option C</label>
                <input type="text" name="option_c" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Option D</label>
                <input type="text" name="option_d" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Correct Option (A, B, C, D)</label>
                <select name="correct_option" class="form-select" required>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Submit Question</button>
        </form>
    </div>
</div>
@endsection
