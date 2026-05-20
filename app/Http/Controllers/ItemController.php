<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display browse page with filters
     */
    public function browse(Request $request)
    {
        $query = Item::active();

        // Apply filters
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->category && $request->category != 'all') {
            $query->where('category', $request->category);
        }

        if ($request->type && $request->type != 'all') {
            $query->where('item_type', $request->type);
        }

        if ($request->condition && $request->condition != 'all') {
            $query->where('condition', $request->condition);
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
        $items = $query->with('user')->paginate(20);
        $itemCount = Item::active()->count();

        // Get filter options
        $categories = Item::distinct()->pluck('category')->sort();
        $conditions = ['New', 'Slightly Used', 'Used'];
        $types = ['Barter', 'Donation'];

        return view('items.browse', [
            'items' => $items,
            'itemCount' => $itemCount,
            'categories' => $categories,
            'conditions' => $conditions,
            'types' => $types,
            'currentFilters' => [
                'type' => $request->type ?? 'all',
                'category' => $request->category ?? 'all',
                'condition' => $request->condition ?? 'all',
                'search' => $request->search ?? '',
                'sort' => $sort,
            ]
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

        return view('items.show', [
            'item' => $item,
            'relatedItems' => $relatedItems,
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
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } else {
            // Default placeholder based on category
            $placeholders = [
                'Books & Textbooks'    => 'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=400&h=400&fit=crop',
                'Electronics'          => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400&h=400&fit=crop',
                'Uniforms & Apparel'   => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=400&fit=crop',
                'Lab Supplies'         => 'https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?w=400&h=400&fit=crop',
                'Furniture'            => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=400&h=400&fit=crop',
                'Art & Craft Supplies' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?w=400&h=400&fit=crop',
                'Office Supplies'      => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?w=400&h=400&fit=crop',
                'Sports Equipment'     => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=400&h=400&fit=crop',
            ];
            $validated['image_url'] = $placeholders[$validated['category']]
                ?? 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400&h=400&fit=crop';
        }

        unset($validated['image']); // remove file from validated array

        $validated['user_id']   = auth()->id();
        $validated['status']    = 'Active';
        $validated['posted_at'] = now();
        $validated['seller_rating'] = 5.0;

        Item::create($validated);

        return redirect()->route('items.browse')
            ->with('success', 'Your item has been posted successfully!');
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
