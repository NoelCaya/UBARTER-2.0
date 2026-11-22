<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Notification;
use App\Models\Trade;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TradeController extends Controller
{
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
            'completed' => Trade::where(fn($q) => $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id))->where('status', 'Completed')->count(),
            'pending'   => Trade::where(fn($q) => $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id))->where('status', 'Pending')->count(),
            'total'     => Trade::where(fn($q) => $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id))->count(),
        ];

        return view('trade-history', compact('trades', 'stats', 'status'));
    }

    public function propose(Request $request)
    {
        $user = auth()->user();
        if ($user->isSuspended()) {
            return back()->with('error', 'Your account is suspended. You cannot propose trades.');
        }

        $request->validate([
            'receiver_item_id'  => 'required|exists:items,id',
            'initiator_item_id' => 'required|exists:items,id',
            'message'           => 'nullable|string|max:500',
        ]);

        $receiverItem  = Item::findOrFail($request->receiver_item_id);
        $initiatorItem = Item::findOrFail($request->initiator_item_id);

        if ($initiatorItem->user_id !== $user->id) {
            return back()->with('error', 'You do not own the item you are offering.');
        }
        if ($receiverItem->user_id === $user->id) {
            return back()->with('error', 'You cannot trade with yourself.');
        }
        if ($receiverItem->item_type !== 'Barter') {
            return back()->with('error', 'This item is not available for barter.');
        }
        if ($receiverItem->status !== 'Active') {
            return back()->with('error', 'This item is no longer available.');
        }

        $exists = Trade::where('initiator_id', $user->id)
            ->where('receiver_item_id', $receiverItem->id)
            ->where('status', 'Pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a pending trade proposal for this item.');
        }

        $trade = Trade::create([
            'initiator_id'      => $user->id,
            'receiver_id'       => $receiverItem->user_id,
            'initiator_item_id' => $initiatorItem->id,
            'receiver_item_id'  => $receiverItem->id,
            'status'            => 'Pending',
            'message'           => $request->message,
        ]);

        // Notify receiver
        Notification::notify(
            $receiverItem->user_id,
            'new_trade',
            'New Trade Proposal',
            "{$user->name} wants to trade "{$initiatorItem->title}" for your "{$receiverItem->title}"",
            route('trade-history'),
            $user->id
        );

        return redirect()->route('trade-history')
            ->with('success', 'Trade proposal sent! The seller will review your offer.');
    }

    public function accept(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($trade->status !== 'Pending') {
            return back()->with('error', 'This trade is no longer pending.');
        }

        $trade->update(['status' => 'Accepted']);

        // Notify initiator
        Notification::notify(
            $trade->initiator_id,
            'trade_accepted',
            'Trade Accepted!',
            auth()->user()->name . " accepted your trade proposal for "{$trade->receiverItem->title}"",
            route('trade-history'),
            auth()->id()
        );

        return back()->with('success', 'Trade accepted! Arrange the exchange with the other party.');
    }

    public function reject(Trade $trade)
    {
        if ($trade->receiver_id !== auth()->id()) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($trade->status !== 'Pending') {
            return back()->with('error', 'This trade is no longer pending.');
        }

        $trade->update(['status' => 'Rejected']);

        // Notify initiator
        Notification::notify(
            $trade->initiator_id,
            'trade_rejected',
            'Trade Rejected',
            auth()->user()->name . " declined your trade proposal for "{$trade->receiverItem->title}"",
            route('trade-history'),
            auth()->id()
        );

        return back()->with('success', 'Trade rejected.');
    }

    /**
     * Mark as completed — BOTH parties must confirm (#18)
     * We use initiator_confirmed / receiver_confirmed flags.
     * When both confirm → status becomes Completed.
     */
    public function complete(Trade $trade)
    {
        $user = auth()->user();

        if ($trade->initiator_id !== $user->id && $trade->receiver_id !== $user->id) {
            return back()->with('error', 'Unauthorized.');
        }
        if ($trade->status !== 'Accepted') {
            return back()->with('error', 'Trade must be accepted first.');
        }

        $isInitiator = $trade->initiator_id === $user->id;

        // Set the confirming party's flag
        if ($isInitiator) {
            $trade->update(['initiator_confirmed' => true]);
        } else {
            $trade->update(['receiver_confirmed' => true]);
        }

        $trade->refresh();

        // Both confirmed → mark completed
        if ($trade->initiator_confirmed && $trade->receiver_confirmed) {
            $trade->update([
                'status'       => 'Completed',
                'completed_at' => now(),
            ]);
            $trade->initiatorItem->update(['status' => 'Traded']);
            $trade->receiverItem->update(['status' => 'Traded']);

            // Notify both parties
            $otherId = $isInitiator ? $trade->receiver_id : $trade->initiator_id;
            Notification::notify(
                $otherId,
                'trade_completed',
                'Trade Completed!',
                "Your trade with {$user->name} is now complete. Leave a review!",
                route('trade-history'),
                $user->id
            );

            return back()->with('success', 'Trade completed! You can now leave a review.');
        }

        // Notify the other party that you confirmed
        $otherId    = $isInitiator ? $trade->receiver_id : $trade->initiator_id;
        $otherLabel = $isInitiator ? 'receiver' : 'initiator';
        Notification::notify(
            $otherId,
            'trade_completion_pending',
            'Trade Completion Pending',
            "{$user->name} has confirmed the trade. Please confirm on your end to complete it.",
            route('trade-history'),
            $user->id
        );

        return back()->with('success', 'You confirmed the trade. Waiting for the other party to confirm.');
    }

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

    public function export(Request $request)
    {
        $user   = auth()->user();
        $trades = Trade::where(fn($q) => $q->where('initiator_id', $user->id)->orWhere('receiver_id', $user->id))
            ->with(['initiator', 'receiver', 'initiatorItem', 'receiverItem'])->latest()->get();

        $filename = 'UBarter_Trade_History_' . date('Y-m-d') . '.csv';

        $response = new StreamedResponse(function () use ($trades, $user) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['UBarter Trade History', 'User: ' . $user->name, 'Exported: ' . now()->format('Y-m-d H:i:s')]);
            fputcsv($handle, []);
            fputcsv($handle, ['Date', 'Status', 'Item Offered', 'Item Requested', 'Trade Partner', 'Message']);
            foreach ($trades as $trade) {
                $partner = $trade->initiator_id === $user->id ? $trade->receiver->name : $trade->initiator->name;
                fputcsv($handle, [
                    $trade->created_at->format('Y-m-d'),
                    $trade->status,
                    $trade->initiatorItem->title ?? 'N/A',
                    $trade->receiverItem->title ?? 'N/A',
                    $partner,
                    $trade->message ?? '',
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        return $response;
    }
}
