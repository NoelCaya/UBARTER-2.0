<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Item;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = auth()->user()->wishlist()
            ->with('item.user')
            ->paginate(12);

        return view('user.wishlist', compact('wishlistItems'));
    }

    public function add(Item $item)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)->exists();

        if (!$exists) {
            Wishlist::create(['user_id' => auth()->id(), 'item_id' => $item->id]);
            $item->increment('wishlist_count');
        }

        return back()->with('success', 'Item added to wishlist!');
    }

    public function remove(Item $item)
    {
        $deleted = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)->delete();

        if ($deleted) {
            $item->decrement('wishlist_count');
        }

        return back()->with('success', 'Item removed from wishlist!');
    }

    /**
     * Toggle wishlist — adds if not wishlisted, removes if already wishlisted (#6)
     */
    public function toggle(Item $item)
    {
        $exists = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)->exists();

        if ($exists) {
            Wishlist::where('user_id', auth()->id())
                ->where('item_id', $item->id)->delete();
            $item->decrement('wishlist_count');
            $inWishlist = false;
            $message    = 'Removed from wishlist.';
        } else {
            Wishlist::create(['user_id' => auth()->id(), 'item_id' => $item->id]);
            $item->increment('wishlist_count');
            $inWishlist = true;
            $message    = 'Added to wishlist!';
        }

        $item->refresh();

        if (request()->expectsJson()) {
            return response()->json([
                'in_wishlist'    => $inWishlist,
                'wishlist_count' => $item->wishlist_count,
                'message'        => $message,
            ]);
        }

        return back()->with('success', $message);
    }

    public function check(Item $item)
    {
        $inWishlist = Wishlist::where('user_id', auth()->id())
            ->where('item_id', $item->id)->exists();

        return response()->json([
            'in_wishlist'    => $inWishlist,
            'wishlist_count' => $item->wishlist_count,
        ]);
    }
}
