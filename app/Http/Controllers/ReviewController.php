<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Item;
use App\Models\Trade;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display user's received reviews
     */
    public function index()
    {
        $user = auth()->user();

        $reviews = Review::where('reviewee_id', $user->id)
            ->with('reviewer', 'item')
            ->latest()
            ->paginate(12);

        $averageRating = Review::where('reviewee_id', $user->id)->avg('rating') ?? 0;
        $totalReviews  = Review::where('reviewee_id', $user->id)->count();

        return view('user.reviews', compact('reviews', 'averageRating', 'totalReviews'));
    }

    /**
     * Show review form — only accessible after a completed trade
     */
    public function create(Request $request, Item $item)
    {
        $user    = auth()->user();
        $tradeId = $request->query('trade_id');

        // Cannot review your own item
        if ($item->user_id === $user->id) {
            return back()->with('error', 'You cannot review your own item.');
        }

        // Must have a completed trade involving this item
        $trade = Trade::where('id', $tradeId)
            ->where('status', 'Completed')
            ->where(function ($q) use ($user) {
                $q->where('initiator_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->where(function ($q) use ($item) {
                $q->where('initiator_item_id', $item->id)
                  ->orWhere('receiver_item_id', $item->id);
            })
            ->first();

        if (!$trade) {
            return back()->with('error', 'You can only review items from completed trades.');
        }

        // Prevent duplicate review for the same trade
        $alreadyReviewed = Review::where('reviewer_id', $user->id)
            ->where('item_id', $item->id)
            ->where('trade_id', $trade->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this trade.');
        }

        return view('reviews.create', compact('item', 'trade'));
    }

    /**
     * Store a new review
     */
    public function store(Request $request, Item $item)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:500',
            'trade_id' => 'required|integer|exists:trades,id',
        ]);

        // Cannot review your own item
        if ($item->user_id === $user->id) {
            return back()->with('error', 'You cannot review your own item.');
        }

        // Verify completed trade
        $trade = Trade::where('id', $validated['trade_id'])
            ->where('status', 'Completed')
            ->where(function ($q) use ($user) {
                $q->where('initiator_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->where(function ($q) use ($item) {
                $q->where('initiator_item_id', $item->id)
                  ->orWhere('receiver_item_id', $item->id);
            })
            ->first();

        if (!$trade) {
            return back()->with('error', 'Invalid trade. Only completed trades can be reviewed.');
        }

        // Prevent duplicates
        $alreadyReviewed = Review::where('reviewer_id', $user->id)
            ->where('item_id', $item->id)
            ->where('trade_id', $trade->id)
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You have already reviewed this trade.');
        }

        Review::create([
            'reviewer_id' => $user->id,
            'reviewee_id' => $item->user_id,
            'item_id'     => $item->id,
            'trade_id'    => $trade->id,
            'rating'      => $validated['rating'],
            'comment'     => $validated['comment'] ?? null,
        ]);

        return redirect()->route('reviews')->with('success', 'Review posted successfully!');
    }

    /**
     * Delete a review (reviewer only)
     */
    public function destroy(Review $review)
    {
        if ($review->reviewer_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
