<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class WishlistApiController extends Controller
{
    /**
     * Get user's wishlist
     */
    public function index(): JsonResponse
    {
        $wishlist = auth()->user()->wishlist()->with('item.user')->paginate(20);

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
    public function add(Item $item): JsonResponse
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Item already in wishlist'
            ], 409);
        }

        Wishlist::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
        ]);

        $item->increment('wishlist_count');

        return response()->json([
            'success' => true,
            'message' => 'Item added to wishlist'
        ], 201);
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Item $item): JsonResponse
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->first();

        if (!$wishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Item not in wishlist'
            ], 404);
        }

        $wishlist->delete();
        $item->decrement('wishlist_count');

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist'
        ]);
    }

    /**
     * Check if item is in wishlist
     */
    public function check(Item $item): JsonResponse
    {
        $inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist
        ]);
    }
}
