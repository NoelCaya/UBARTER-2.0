<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Item;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Display wishlist
     */
    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()
            ->with('item.user')
            ->paginate(12);

        return view('user.wishlist', [
            'wishlistItems' => $wishlistItems,
        ]);
    }

    /**
     * Add item to wishlist
     */
    public function add(Item $item)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => auth()->id(),
                'item_id' => $item->id,
            ]);
        }

        return back()->with('success', 'Item added to wishlist!');
    }

    /**
     * Remove item from wishlist
     */
    public function remove(Item $item)
    {
        Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->delete();

        return back()->with('success', 'Item removed from wishlist!');
    }

    /**
     * Check if item is in wishlist (API)
     */
    public function check(Item $item)
    {
        $inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)
            ->exists();

        return response()->json(['in_wishlist' => $inWishlist]);
    }
}
