<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display user's reviews
     */
    public function index()
    {
        $reviews = auth()->user()->reviewsReceived()
            ->with('reviewer', 'item')
            ->paginate(12);

        $averageRating = auth()->user()->reviewsReceived()->avg('rating') ?? 0;
        $totalReviews = auth()->user()->reviewsReceived()->count();

        return view('user.reviews', [
            'reviews' => $reviews,
            'averageRating' => $averageRating,
            'totalReviews' => $totalReviews,
        ]);
    }

    /**
     * Show review form for an item
     */
    public function create(Item $item)
    {
        // User can only review if they traded with the item owner
        $traded = auth()->user()->id !== $item->user_id;

        if (!$traded) {
            return back()->with('error', 'You cannot review your own items!');
        }

        return view('reviews.create', ['item' => $item]);
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Item $item)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        Review::create([
            'reviewer_id' => auth()->id(),
            'reviewee_id' => $item->user_id,
            'item_id' => $item->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return redirect()->route('reviews')->with('success', 'Review posted successfully!');
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        if ($review->reviewer_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action');
        }

        $review->delete();

        return back()->with('success', 'Review deleted successfully!');
    }
}
