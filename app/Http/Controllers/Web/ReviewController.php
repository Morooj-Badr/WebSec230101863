<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web')->only(['store']);
    }

    public function store(Request $request, Product $product)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return redirect()->back()->with('error', 'You must be logged in to submit a review.');
            }

            // Check if user has Customer role
            if (!Auth::user()->hasRole('Customer')) {
                return redirect()->back()->with('error', 'Only customers can submit reviews.');
            }

            $request->validate([
                'rating' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:1000'
            ]);

            $review = new Review([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

            $review->save();

            return redirect()->back()->with('success', 'Review submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Error storing review: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to submit review. Please try again.');
        }
    }

    public function show(Product $product)
    {
        try {
            $reviews = $product->reviews()->with('user')->latest()->get();
            return view('products.reviews', compact('product', 'reviews'));
        } catch (\Exception $e) {
            Log::error('Error showing reviews: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load reviews. Please try again.');
        }
    }
} 