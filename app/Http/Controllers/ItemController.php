<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Dashboard — shows real items from DB
     */
    public function dashboard()
    {
        $recentItems = Item::active()
            ->with('user')
            ->latest('posted_at')
            ->take(12)
            ->get();

        $user = auth()->user();
        $pendingTrades = \App\Models\Trade::where('receiver_id', $user->id)
            ->where('status', 'Pending')
            ->count();

        return view('dashboard', compact('recentItems', 'pendingTrades'));
    }

    /**
     * Display browse page with filters
     */
    public function browse(Request $request)
    {
        $query = Item::active()->where('item_type', 'Barter');

        // All defined categories — always show even if empty (#10)
        $allCategories = ['Books & Textbooks', 'Uniforms & Apparel', 'Lab Supplies', 'Electronics', 'Furniture', 'Art & Craft Supplies', 'Office Supplies', 'Sports Equipment', 'General'];

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->condition && $request->condition !== 'all') {
            $query->where('condition', $request->condition);
        }

        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'most_viewed':     $query->mostViewed(); break;
            case 'highest_rated':   $query->highestRated(); break;
            case 'most_wishlisted': $query->orderBy('wishlist_count', 'desc'); break;
            default:                $query->newest();
        }

        $items     = $query->with('user')->paginate(20);
        $itemCount = Item::active()->where('item_type', 'Barter')->count();

        $conditions = ['New', 'Slightly Used', 'Used'];

        return view('items.browse', [
            'items'          => $items,
            'itemCount'      => $itemCount,
            'categories'     => $allCategories,
            'conditions'     => $conditions,
            'currentFilters' => [
                'category'  => $request->category ?? 'all',
                'condition' => $request->condition ?? 'all',
                'search'    => $request->search ?? '',
                'sort'      => $sort,
            ],
        ]);
    }

    /**
     * Show a single item
     */
    public function show(Item $item)
    {
        $item->increment('views');
        $relatedItems = Item::active()
            ->where('category', $item->category)
            ->where('id', '!=', $item->id)
            ->with('user')
            ->take(5)
            ->get();

        // Get the current user's active barter items to offer in a trade
        $myItems = auth()->check()
            ? Item::where('user_id', auth()->id())
                  ->where('status', 'Active')
                  ->where('item_type', 'Barter')
                  ->get()
            : collect();

        return view('items.show', [
            'item'         => $item,
            'relatedItems' => $relatedItems,
            'myItems'      => $myItems,
        ]);
    }

    /**
     * Create item form
     */
    public function create()
    {
        $categories = ['Books & Textbooks', 'Uniforms & Apparel', 'Lab Supplies', 'Electronics', 'Furniture', 'Art & Craft Supplies', 'Office Supplies', 'Sports Equipment', 'General'];
        $conditions = ['New', 'Slightly Used', 'Used'];
        $types = ['Barter', 'Donation'];

        return view('items.create', [
            'categories' => $categories,
            'conditions' => $conditions,
            'types' => $types,
        ]);
    }

    /**
     * Store item
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category'    => 'required|string',
            'condition'   => 'required|in:New,Slightly Used,Used',
            'item_type'   => 'required|in:Barter,Donation',
            'looking_for' => 'nullable|string|max:500',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('image')->store('items', 'public');
        $validated['image_url'] = '/storage/' . $path;

        unset($validated['image']); // remove file from validated array

        $validated['user_id']       = auth()->id();
        // Barter items go live immediately; Donations require admin approval
        $validated['status']        = $validated['item_type'] === 'Donation' ? 'Pending' : 'Active';
        $validated['posted_at']     = now();
        $validated['seller_rating'] = 5.0;

        Item::create($validated);

        return redirect()->route('items.browse')
            ->with('success', $validated['item_type'] === 'Donation'
                ? 'Your donation has been submitted for review. It will appear once approved by UBARTER Admin.'
                : 'Your item is now live on the marketplace!');
    }

    /**
     * Donated Items — all active donation items (visible to all students + CES admin)
     */
    public function donatedItems(Request $request)
    {
        $query = Item::where('item_type', 'Donation')
                     ->where('status', 'Active')
                     ->with('user');

        // Search
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Category filter
        if ($request->category && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Condition filter
        if ($request->condition && $request->condition !== 'all') {
            $query->where('condition', $request->condition);
        }

        // Sort
        switch ($request->sort ?? 'newest') {
            case 'most_viewed':
                $query->mostViewed();
                break;
            case 'most_wishlisted':
                $query->orderBy('wishlist_count', 'desc');
                break;
            default:
                $query->newest();
        }

        $items      = $query->paginate(20)->appends($request->query());
        $totalCount = Item::where('item_type', 'Donation')->where('status', 'Active')->count();
        // Always show all defined categories, even if empty
        $allCategories = ['Books & Textbooks', 'Uniforms & Apparel', 'Lab Supplies', 'Electronics', 'Furniture', 'Art & Craft Supplies', 'Office Supplies', 'Sports Equipment', 'General'];
        $categories = collect($allCategories);
        $conditions = ['New', 'Slightly Used', 'Used'];

        return view('items.donated', compact('items', 'totalCount', 'categories', 'conditions'));
    }

    /**
     * My Items — list the authenticated user's own posts
     */
    public function myItems()
    {
        $items = Item::where('user_id', auth()->id())
                     ->whereNotIn('status', ['Archived'])
                     ->latest('posted_at')
                     ->paginate(20);

        return view('items.my-items', compact('items'));
    }

    /**
     * Edit form for an item the user owns
     */
    public function edit(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'You do not own this item.');
        }

        $categories = ['Books & Textbooks', 'Uniforms & Apparel', 'Lab Supplies', 'Electronics', 'Furniture', 'Art & Craft Supplies', 'Office Supplies', 'Sports Equipment', 'General'];
        $conditions = ['New', 'Slightly Used', 'Used'];

        return view('items.edit', compact('item', 'categories', 'conditions'));
    }

    /**
     * Update an item
     */
    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'You do not own this item.');
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category'    => 'required|string',
            'condition'   => 'required|in:New,Slightly Used,Used',
            'looking_for' => 'nullable|string|max:500',
            'image'       => $item->image_url
                ? 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
                : 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image']);

        // Re-submit for approval if it was already active/pending
        if (in_array($item->status, ['Active', 'Pending'])) {
            $validated['status'] = 'Pending';
        }

        $item->update($validated);

        return redirect()->route('items.my-items')
            ->with('success', 'Item updated. It has been re-submitted for admin review.');
    }

    /**
     * Cancel (archive) an item — soft-removes it from the marketplace
     */
    public function cancel(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'You do not own this item.');
        }

        \Illuminate\Support\Facades\DB::table('items')
            ->where('id', $item->id)
            ->update(['status' => 'Archived']);

        return back()->with('success', "\"$item->title\" has been cancelled and removed from the marketplace.");
    }

    /**
     * Permanently delete an item — safely remove related records first (#8)
     */
    public function destroy(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'You do not own this item.');
        }

        $title = $item->title;

        // Remove related wishlists and reviews before deleting
        \App\Models\Wishlist::where('item_id', $item->id)->delete();
        \App\Models\Review::where('item_id', $item->id)->update(['item_id' => null]);

        $item->delete();

        return redirect()->route('items.my-items')
            ->with('success', "\"$title\" has been permanently deleted.");
    }

    /**
     * Search items
     */
    public function search(Request $request)
    {
        $query = Item::active();
        $searchQuery = $request->input('q', '');

        // Search by title and description
        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply filters
        if ($request->category && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        if ($request->condition && $request->condition != 'all') {
            $query->where('condition', $request->condition);
        }

        if ($request->type && $request->type != 'all') {
            $query->where('item_type', $request->type);
        }

        // Apply sorting
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'newest':
                $query->newest();
                break;
            case 'most_viewed':
                $query->mostViewed();
                break;
            case 'highest_rated':
                $query->highestRated();
                break;
            case 'most_wishlisted':
                $query->orderBy('wishlist_count', 'desc');
                break;
            default:
                $query->newest();
        }

        // Paginate
        $items = $query->with('user')->paginate(12);

        // Get filter options
        $categories = Item::distinct()->pluck('category')->sort();
        $conditions = ['New', 'Slightly Used', 'Used'];
        $types = ['Barter', 'Donation'];

        return view('items.search', [
            'items' => $items,
            'query' => $searchQuery,
            'categories' => $categories,
            'conditions' => $conditions,
            'types' => $types,
            'currentFilters' => [
                'type' => $request->type ?? 'all',
                'category' => $request->category ?? 'all',
                'condition' => $request->condition ?? 'all',
                'sort' => $sort,
            ]
        ]);
    }
}
