<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * Get current authenticated user
     */
    public function me(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => auth()->user()
        ]);
    }

    /**
     * Get user profile by ID
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $user->load('items')
        ]);
    }

    /**
     * Update user profile
     */
    public function update(Request $request): JsonResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'bio' => 'sometimes|string|max:500',
            'avatar_url' => 'sometimes|nullable|url',
            'phone' => 'sometimes|nullable|string|max:20',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Get user's items
     */
    public function items(User $user): JsonResponse
    {
        $items = $user->items()->with('reviews')->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ]
        ]);
    }

    /**
     * Get user's rating and reviews
     */
    public function rating(User $user): JsonResponse
    {
        $reviews = $user->reviewsReceived()->paginate(10);
        $averageRating = $user->reviewsReceived()->avg('rating') ?? 0;

        return response()->json([
            'success' => true,
            'data' => [
                'average_rating' => round($averageRating, 2),
                'total_reviews' => $user->reviewsReceived()->count(),
                'reviews' => $reviews->items(),
            ],
            'pagination' => [
                'total' => $reviews->total(),
                'per_page' => $reviews->perPage(),
                'current_page' => $reviews->currentPage(),
                'last_page' => $reviews->lastPage(),
            ]
        ]);
    }
}
