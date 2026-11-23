<?php

namespace App\Http\Controllers;

use App\Models\DonationClaim;
use App\Models\Item;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DonationClaimController extends Controller
{
    /**
     * User submits a claim request for a donation item.
     */
    public function store(Request $request, Item $item)
    {
        // Only active donation items can be claimed
        if ($item->item_type !== 'Donation' || $item->status !== 'Active') {
            return back()->with('error', 'This item is not available for claiming.');
        }

        if (DonationClaim::where('item_id', $item->id)->where('status', 'Approved')->exists()) {
            return back()->with('error', 'This donation has already been assigned.');
        }

        // Can't claim your own item
        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'You cannot claim your own item.');
        }

        // Prevent duplicate pending claim
        $existing = DonationClaim::where('item_id', $item->id)
            ->where('claimant_id', auth()->id())
            ->exists();

        if ($existing) {
            return back()->with('error', 'You have already submitted a claim request for this item.');
        }

        $request->validate([
            'claim_message' => 'nullable|string|max:500',
        ]);

        DonationClaim::create([
            'item_id'    => $item->id,
            'claimant_id'=> auth()->id(),
            'message'    => $request->claim_message,
            'status'     => 'Pending',
        ]);

        // Notify CES Admin (all admins)
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::notify(
                $admin->id,
                'donation_claim',
                'New Donation Claim Request',
                'A user submitted a request to claim a donation. Review it in the admin panel.',
                route('admin.donations.claims')
            );
        }

        return back()->with('success', 'Your claim request has been submitted. CES Admin will review it shortly.');
    }

    /**
     * Admin: list all pending donation claim requests.
     */
    public function adminIndex()
    {
        $this->requireAdmin();

        $claims = DonationClaim::with(['item.user', 'claimant'])
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        return view('admin.donation-claims', compact('claims'));
    }

    /**
     * Admin: approve a claim.
     */
    public function approve(DonationClaim $claim)
    {
        $this->requireAdmin();

        $approved = DB::transaction(function () use ($claim): bool {
            $claim = DonationClaim::whereKey($claim->id)->lockForUpdate()->firstOrFail();
            $item = Item::whereKey($claim->item_id)->lockForUpdate()->firstOrFail();

            if ($claim->status !== 'Pending' ||
                $item->item_type !== 'Donation' ||
                $item->status !== 'Active' ||
                DonationClaim::where('item_id', $item->id)->where('status', 'Approved')->exists()) {
                return false;
            }

            $claim->update(['status' => 'Approved']);
            $item->update(['status' => 'Traded']);

            DonationClaim::where('item_id', $item->id)
                ->where('id', '!=', $claim->id)
                ->where('status', 'Pending')
                ->update(['status' => 'Rejected']);

            return true;
        });

        if (!$approved) {
            return back()->with('error', 'This claim or donation is no longer available for approval.');
        }

        // Notify claimant
        Notification::notify(
            $claim->claimant_id,
            'claim_approved',
            'Donation Claim Approved!',
            'CES Admin approved your donation claim. Contact the donor to arrange pickup.',
            route('chat.show', $claim->item->user_id)
        );

        // Notify donor
        Notification::notify(
            $claim->item->user_id,
            'claim_assigned',
            'Donation Recipient Assigned',
            'CES Admin assigned a recipient to one of your donations.',
            route('chat.show', $claim->claimant_id)
        );

        return back()->with('success', 'Claim approved. Both parties have been notified.');
    }

    /**
     * Admin: reject a claim.
     */
    public function reject(DonationClaim $claim)
    {
        $this->requireAdmin();

        if ($claim->status !== 'Pending') {
            return back()->with('error', 'Only pending claims can be rejected.');
        }

        $claim->update(['status' => 'Rejected']);

        Notification::notify(
            $claim->claimant_id,
            'claim_rejected',
            'Donation Claim Not Approved',
            'Your donation claim request was not approved at this time.',
            route('items.donated')
        );

        return back()->with('success', 'Claim rejected.');
    }

    private function requireAdmin(): void
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Access denied.');
        }
    }
}
