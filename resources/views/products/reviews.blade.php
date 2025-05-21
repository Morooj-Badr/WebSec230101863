@extends('layouts.master')
@section('title', 'Product Reviews')
@section('content')
<div class="container mt-4">
    <h2>Reviews for {{ $product->name }}</h2>

    @if(auth()->check() && auth()->user()->can('add_review'))
    <div class="card mb-4">
        <div class="card-body">
            <h4>Write a Review</h4>
            <form action="{{ route('reviews.store', $product->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="rating">Rating:</label>
                    <select name="rating" id="rating" class="form-control" required>
                        <option value="">Select Rating</option>
                        <option value="1">1 Star</option>
                        <option value="2">2 Stars</option>
                        <option value="3">3 Stars</option>
                        <option value="4">4 Stars</option>
                        <option value="5">5 Stars</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <label for="comment">Your Review:</label>
                    <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit Review</button>
            </form>
        </div>
    </div>
    @endif

    <h4>Customer Reviews</h4>
    @forelse($reviews as $review)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5 class="card-title">{{ $review->user->name }}</h5>
                <div class="text-warning">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }}"></i>
                    @endfor
                </div>
            </div>
            <p class="card-text">{{ $review->comment }}</p>
            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
        </div>
    </div>
    @empty
    <p>No reviews yet. Be the first to review this product!</p>
    @endforelse
</div>
@endsection 