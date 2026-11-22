<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Store a new report from the chat/messaging area
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reported_user_id'  => 'required|exists:users,id',
            'conversation_id'   => 'nullable|exists:conversations,id',
            'reason'            => 'required|in:Fraudulous Behavior,Inappropriate Behavior,Verbal Abuse,Spam,Fake Item Listing,Scam Attempt,Other',
            'details'           => 'nullable|string|max:1000',
        ]);

        // Cannot report yourself
        if ($validated['reported_user_id'] == Auth::id()) {
            return back()->with('error', 'You cannot report yourself.');
        }

        // Prevent duplicate pending reports for the same user+conversation
        $exists = Report::where('reporter_id', Auth::id())
            ->where('reported_user_id', $validated['reported_user_id'])
            ->where('status', 'Pending')
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have a pending report against this user.');
        }

        Report::create([
            'reporter_id'       => Auth::id(),
            'reported_user_id'  => $validated['reported_user_id'],
            'conversation_id'   => $validated['conversation_id'] ?? null,
            'reason'            => $validated['reason'],
            'details'           => $validated['details'] ?? null,
            'status'            => 'Pending',
        ]);

        return back()->with('success', 'Report submitted. CES Admin will review it shortly.');
    }
}
