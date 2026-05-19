<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WishlistController extends Controller
{
    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        
        $wishlist = $user->wishlist()
            ->with('item.user')
            ->paginate($request->per_page ?? 12);

        return response()->json([
            'success' => true,
            'data' => $wishlist->items(),
            'pagination' => [
                'total' => $wishlist->total(),
                'per_page' => $wishlist->perPage(),
                'current_page' => $wishlist->currentPage(),
                'last_page' => $wishlist->lastPage(),
            ]
        ]);
    }

    /**
     * Add item to wishlist
     */
    public function add(Item $item)
    {
        $user = auth()->user();

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Item already in wishlist'
            ], Response::HTTP_CONFLICT);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // Increment wishlist count
        $item->increment('wishlist_count');

        return response()->json([
            'success' => true,
            'message' => 'Item added to wishlist'
        ], Response::HTTP_CREATED);
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Item $item)
    {
        $user = auth()->user();

        $deleted = Wishlist::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Item not in wishlist'
            ], Response::HTTP_NOT_FOUND);
        }

        // Decrement wishlist count
        $item->decrement('wishlist_count');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist'
        ]);
    }

    /**
     * Check if item is in wishlist
     */
    public function check(Item $item)
    {
        $user = auth()->user();

        $inWishlist = Wishlist::where('user_id', $user->id)
            ->where('item_id', $item->id)
            ->exists();

        return response()->json([
            'success' => true,
            'data' => ['in_wishlist' => $inWishlist]
        ]);
    }
}
