<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ItemApiController extends Controller
{
    /**
     * Get all items with filters and pagination
     */
    public function index(Request $request): JsonResponse
    {
        $query = Item::active();

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
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
        $perPage = $request->per_page ?? 20;
        $items = $query->with('user')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $items->items(),
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem(),
            ]
        ]);
    }

    /**
     * Get a single item
     */
    public function show(Item $item): JsonResponse
    {
        $item->increment('views');
        
        $relatedItems = Item::active()
            ->where('category', $item->category)
            ->where('id', '!=', $item->id)
            ->with('user')
            ->take(5)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $item->load('user'),
            'related_items' => $relatedItems
        ]);
    }

    /**
     * Create a new item
     */
    public function store(Request $request): JsonResponse
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
        $validated['status'] = 'Active';
        $validated['posted_at'] = now();

        $item = Item::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item created successfully',
            'data' => $item
        ], 201);
    }

    /**
     * Update an item
     */
    public function update(Request $request, Item $item): JsonResponse
    {
        // Check authorization
        if ($item->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string|max:1000',
            'category' => 'sometimes|string',
            'condition' => 'sometimes|in:New,Slightly Used,Used',
            'item_type' => 'sometimes|in:Barter,Donation',
            'image_url' => 'nullable|url',
            'status' => 'sometimes|in:Active,Pending,Traded,Archived',
        ]);

        $item->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully',
            'data' => $item
        ]);
    }

    /**
     * Delete an item
     */
    public function destroy(Item $item): JsonResponse
    {
        // Check authorization
        if ($item->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $item->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully'
        ]);
    }

    /**
     * Get filter options
     */
    public function getFilterOptions(): JsonResponse
    {
        $categories = Item::distinct()->pluck('category')->sort();
        $conditions = ['New', 'Slightly Used', 'Used'];
        $types = ['Barter', 'Donation'];

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'conditions' => $conditions,
                'types' => $types,
            ]
        ]);
    }

    /**
     * Search items
     */
    public function search(Request $request): JsonResponse
    {
        $query = Item::active();
        $searchQuery = $request->input('q', '');

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

        $perPage = $request->per_page ?? 12;
        $items = $query->with('user')->paginate($perPage);

        return response()->json([
            'success' => true,
            'query' => $searchQuery,
            'data' => $items->items(),
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
            ]
        ]);
    }
}
