<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Trade;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TradeController extends Controller
{
    /**
     * List the authenticated user's trades
     */
    public function index(Request $request)
    {
        $user   = auth()->user();
        $status = $request->status ?? 'all';

        $query = Trade::where(function ($q) use ($user) {
            $q->where('initiator_id', $user->id)
              ->orWhere('receiver_id', $user->id);
        })->with(['initiator', 'receiver', 'initiatorItem', 'receiverItem']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $trades = $query->latest()->paginate(15);

        $stats = [
            'completed' => Trade::where(function ($q) use ($user) {
                $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id);
            })->where('status', 'Completed')->count(),
            'pending' => Trade::where(function ($q) use ($user) {
                $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id);
            })->where('status', 'Pending')->count(),
            'total' => Trade::where(function ($q) use ($user) {
                $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id);
            })->count(),
        ];

        return view('trade-history', compact('trades', 'stats', 'status'));
    }

    /**
     * Propose a barter trade
     * POST /trades/propose
     */
    public function propose(Request $request)
    {
        $request->validate([
            'receiver_item_id'  => 'required|exists:items,id',
            'initiator_item_id' => 'required|exists:items,id',
            'message'           => 'nullable|string|max:500',
        ]);

        $receiverItem  = Item::findOrFail($request->receiver_item_id);
        $initiatorItem = Item::findOrFail($request->initiator_item_id);

        // Validate ownership
        if ($initiatorItem->user_id !== auth()->id()) {
            return back()->with('error', 'You do not own the item you are offering.');
        }
        if ($receiverItem->user_id === auth()->id()) {
            return back()->with('error', 'You cannot trade with yourself.');
        }
        if ($receiverItem->item_type !== 'Barter') {
            return back()->with('error', 'This item is not available for barter.');
        }
        if ($receiverItem->status !== 'Active') {
            return back()->with('error', 'This item is no longer available.');
        }

        // Check for duplicate pending trade
        $exists = Trade::where('initiator_id', auth()->id())
            ->where('receiver_item_id', $receiverItem->id)
            ->where('status', 'Pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a pending trade proposal for this item.');
        }

        Trade::create([
            'initiator_id'      => auth()->id(),
            'receiver_id'       => $receiverItem->user_id,
            'initiator_item_id' => $initiatorItem->id,
            'receiver_item_id'  => $receiverItem->id,
            'status'            => 'Pending',
            'message'           => $request->message,
        ]);

        return redirect()->route('trade-history')
            ->with('success', 'Trade proposal sent! The seller will review your offer.');
    }

    /**
     * Accept a trade (receiver only)
     */
    public function accept(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($trade->status !== 'Pending') {
            return back()->with('error', 'This trade is no longer pending.');
        }

        $trade->update(['status' => 'Accepted']);

        return back()->with('success', 'Trade accepted! Arrange the exchange with the other party.');
    }

    /**
     * Reject a trade (receiver only)
     */
    public function reject(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($trade->status !== 'Pending') {
            return back()->with('error', 'This trade is no longer pending.');
        }

        $trade->update(['status' => 'Rejected']);

        return back()->with('success', 'Trade rejected.');
    }

    /**
     * Mark a trade as completed (either party)
     */
    public function complete(Trade $trade)
    {
        $user = auth()->user();
        if ($trade->initiator_id !== $user->id && $trade->receiver_id !== $user->id) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($trade->status !== 'Accepted') {
            return back()->with('error', 'Trade must be accepted before it can be completed.');
        }

        $trade->update([
            'status'       => 'Completed',
            'completed_at' => now(),
        ]);

        // Mark both items as Traded
        $trade->initiatorItem->update(['status' => 'Traded']);
        $trade->receiverItem->update(['status' => 'Traded']);

        return back()->with('success', 'Trade marked as completed!');
    }

    /**
     * Cancel a trade (initiator only, while Pending)
     */
    public function cancel(Trade $trade)
    {
        if ($trade->initiator_id !== auth()->id()) {
            return back()->with('error', 'Only the proposer can cancel a trade.');
        }
        if (!in_array($trade->status, ['Pending', 'Accepted'])) {
            return back()->with('error', 'This trade cannot be cancelled.');
        }

        $trade->update(['status' => 'Cancelled']);

        return back()->with('success', 'Trade cancelled.');
    }

    /**
     * Export trade history to CSV
     */
    public function export(Request $request)
    {
        $user   = auth()->user();
        $trades = Trade::where(function ($q) use ($user) {
            $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id);
        })->with(['initiator', 'receiver', 'initiatorItem', 'receiverItem'])->latest()->get();

        $filename = 'UBarter_Trade_History_' . date('Y-m-d') . '.csv';

        $response = new StreamedResponse(function () use ($trades, $user) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['UBarter Trade History', 'User: ' . $user->name, 'Exported: ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($file, []);
            fputcsv($file, ['Date', 'Status', 'Item Offered', 'Item Requested', 'Trade Partner', 'Message']);
            foreach ($trades as $trade) {
                $partner = $trade->initiator_id === $user->id ? $trade->receiver->name : $trade->initiator->name;
                fputcsv($file, [
                    $trade->created_at->format('Y-m-d'),
                    $trade->status,
                    $trade->initiatorItem->title ?? 'N/A',
                    $trade->receiverItem->title ?? 'N/A',
                    $partner,
                    $trade->message ?? '',
                ]);
            }
            fclose($file);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }
}
