<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TradeController extends Controller
{
    /**
     * Get user's trades
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->status ?? 'all';

        $query = Trade::where(function ($q) use ($user) {
            $q->where('initiator_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        });

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $trades = $query->with(['initiator', 'receiver', 'initiatorItem', 'receiverItem'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return response()->json([
            'success' => true,
            'data' => $trades->items(),
            'pagination' => [
                'total' => $trades->total(),
                'per_page' => $trades->perPage(),
                'current_page' => $trades->currentPage(),
                'last_page' => $trades->lastPage(),
            ]
        ]);
    }

    /**
     * Get a single trade
     */
    public function show(Trade $trade)
    {
        $user = auth()->user();

        // Check authorization
        if ($trade->initiator_id !== $user->id && $trade->receiver_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], Response::HTTP_FORBIDDEN);
        }

        $trade->load(['initiator', 'receiver', 'initiatorItem', 'receiverItem']);

        return response()->json([
            'success' => true,
            'data' => $trade
        ]);
    }

    /**
     * Create a trade request
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'initiator_item_id' => 'required|exists:items,id',
            'receiver_item_id' => 'required|exists:items,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:500',
        ]);

        $user = auth()->user();

        // Validate that initiator owns the initiator item
        $initiatorItem = \App\Models\Item::find($validated['initiator_item_id']);
        if ($initiatorItem->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'You do not own this item'
            ], Response::HTTP_FORBIDDEN);
        }

        // Validate that receiver owns the receiver item
        $receiverItem = \App\Models\Item::find($validated['receiver_item_id']);
        if ($receiverItem->user_id !== $validated['receiver_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Receiver does not own this item'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $validated['initiator_id'] = $user->id;
        $validated['status'] = 'Pending';

        $trade = Trade::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Trade request created successfully',
            'data' => $trade->load(['initiator', 'receiver', 'initiatorItem', 'receiverItem'])
        ], Response::HTTP_CREATED);
    }

    /**
     * Update trade status
     */
    public function update(Request $request, Trade $trade)
    {
        $user = auth()->user();

        // Check authorization - only receiver can accept/reject
        if ($trade->receiver_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Only the receiver can update this trade'
            ], Response::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'status' => 'required|in:Accepted,Rejected,Completed,Cancelled',
        ]);

        $trade->update($validated);

        // If trade is completed, update item statuses
        if ($validated['status'] === 'Completed') {
            $trade->initiatorItem->update(['status' => 'Traded']);
            $trade->receiverItem->update(['status' => 'Traded']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Trade updated successfully',
            'data' => $trade->load(['initiator', 'receiver', 'initiatorItem', 'receiverItem'])
        ]);
    }
}
