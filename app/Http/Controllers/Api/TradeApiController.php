<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TradeApiController extends Controller
{
    /**
     * Get user's trades
     */
    public function index(): JsonResponse
    {
        $trades = Trade::where('initiator_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with('initiator', 'receiver', 'initiatorItem', 'receiverItem')
            ->paginate(20);

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
    public function show(Trade $trade): JsonResponse
    {
        // Check authorization
        if ($trade->initiator_id !== auth()->id() && $trade->receiver_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $trade->load('initiator', 'receiver', 'initiatorItem', 'receiverItem')
        ]);
    }

    /**
     * Create a trade request
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'initiator_item_id' => 'required|exists:items,id',
            'receiver_item_id' => 'required|exists:items,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:500',
        ]);

        // Verify items belong to correct users
        $initiatorItem = \App\Models\Item::find($validated['initiator_item_id']);
        $receiverItem = \App\Models\Item::find($validated['receiver_item_id']);

        if ($initiatorItem->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You do not own the initiator item'
            ], 403);
        }

        if ($receiverItem->user_id !== $validated['receiver_id']) {
            return response()->json([
                'success' => false,
                'message' => 'Receiver does not own the receiver item'
            ], 403);
        }

        $trade = Trade::create([
            'initiator_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'initiator_item_id' => $validated['initiator_item_id'],
            'receiver_item_id' => $validated['receiver_item_id'],
            'message' => $validated['message'] ?? null,
            'status' => 'Pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Trade request created successfully',
            'data' => $trade->load('initiator', 'receiver', 'initiatorItem', 'receiverItem')
        ], 201);
    }

    /**
     * Update trade status
     */
    public function update(Request $request, Trade $trade): JsonResponse
    {
        // Check authorization
        if ($trade->receiver_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Only the receiver can update trade status'
            ], 403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Accepted,Rejected,Completed,Cancelled',
        ]);

        $trade->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Trade updated successfully',
            'data' => $trade
        ]);
    }

    /**
     * Cancel a trade
     */
    public function cancel(Trade $trade): JsonResponse
    {
        // Check authorization
        if ($trade->initiator_id !== auth()->id() && $trade->receiver_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        if ($trade->status !== 'Pending') {
            return response()->json([
                'success' => false,
                'message' => 'Can only cancel pending trades'
            ], 400);
        }

        $trade->update(['status' => 'Cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Trade cancelled successfully'
        ]);
    }
}
