<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Browse all items with filters
     */
    public function browse(Request $request)
    {
        $query = Item::active();

        // Filter by item type
        if ($request->has('type') && $request->type != 'all') {
            $query->byType($request->type);
        }

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $query->category($request->category);
        }

        // Filter by condition
        if ($request->has('condition') && $request->condition != 'all') {
            $query->byCondition($request->condition);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        // Sorting
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category' => 'required|string',
            'condition' => 'required|in:New,Slightly Used,Used',
            'item_type' => 'required|in:Barter,Donation',
            'image_url' => 'nullable|url',
        ]);

        $validated['user_id'] = auth()->id();

        Item::create($validated);

        return redirect()->route('items.browse')->with('success', 'Item posted successfully!');
    }
}
