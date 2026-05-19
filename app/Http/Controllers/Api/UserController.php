<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Get user profile
     */
    public function show(User $user)
    {
        $user->load('items');

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar_url' => $user->avatar_url,
                'bio' => $user->bio ?? '',
                'rating' => $user->rating ?? 5.0,
                'items_count' => $user->items()->where('status', 'Active')->count(),
                'trades_count' => $user->trades_count ?? 0,
                'created_at' => $user->created_at,
            ]
        ]);
    }

    /**
     * Get user's items
     */
    public function items(User $user, Request $request)
    {
        $query = $user->items()->where('status', 'Active');

        // Apply filters
        if ($request->category) {
            $query->where('category', $request->category);
        }

        if ($request->type) {
            $query->where('item_type', $request->type);
        }

        $items = $query->paginate($request->per_page ?? 12);

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
     * Update user profile
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'bio' => 'sometimes|string|max:500',
            'phone' => 'sometimes|string|max:20',
        ]);

        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'data' => $user
        ]);
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = auth()->user();

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar_url' => '/storage/' . $path]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Avatar updated successfully',
            'data' => ['avatar_url' => $user->avatar_url]
        ]);
    }
}
