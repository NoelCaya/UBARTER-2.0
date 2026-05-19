<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * Get reviews for a user
     */
    public function userReviews(User $user, Request $request)
    {
        $reviews = $user->receivedReviews()
            ->with('reviewer')
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'success' => true,
            'data' => $reviews->items(),
            'pagination' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
            ],
            'average_rating' => $user->receivedReviews()->avg('rating') ?? 5.0,
            'total_reviews' => $user->receivedReviews()->count(),
        ]);
    }

    /**
     * Create a review
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewed_user_id' => 'required|exists:users,id|different:user_id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
            'trade_id' => 'nullable|exists:trades,id',
        ]);

        $validated['reviewer_id'] = auth()->id();

        // Check if review already exists for this trade
        if ($request->trade_id) {
            $exists = Review::where('reviewer_id', auth()->id())
                ->where('reviewed_user_id', $validated['reviewed_user_id'])
                ->where('trade_id', $request->trade_id)
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already reviewed this user for this trade'
                ], Response::HTTP_CONFLICT);
            }
        }

        $review = Review::create($validated);

        // Update user's average rating
        $reviewedUser = $review->reviewedUser;
        $avgRating = $reviewedUser->receivedReviews()->avg('rating');
        $reviewedUser->update(['rating' => $avgRating]);

        return response()->json([
            'success' => true,
            'message' => 'Review created successfully',
            'data' => $review->load('reviewer')
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a review
     */
    public function update(Request $request, Review $review)
    {
        // Check authorization
        if ($review->reviewer_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string|max:500',
        ]);

        $review->update($validated);

        // Update user's average rating
        $reviewedUser = $review->reviewedUser;
        $avgRating = $reviewedUser->receivedReviews()->avg('rating');
        $reviewedUser->update(['rating' => $avgRating]);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully',
            'data' => $review
        ]);
    }

    /**
     * Delete a review
     */
    public function destroy(Review $review)
    {
        // Check authorization
        if ($review->reviewer_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        $reviewedUserId = $review->reviewed_user_id;
        $review->delete();

        // Update user's average rating
        $reviewedUser = User::find($reviewedUserId);
        if ($reviewedUser) {
            $avgRating = $reviewedUser->receivedReviews()->avg('rating');
            $reviewedUser->update(['rating' => $avgRating ?? 5.0]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully'
        ]);
    }
}
