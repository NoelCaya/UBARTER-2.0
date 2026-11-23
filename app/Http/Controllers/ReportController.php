<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Report;
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

        // Keep only one unresolved report from a reporter against each user.
        $exists = Report::where('reporter_id', Auth::id())
            ->where('reported_user_id', $validated['reported_user_id'])
            ->whereIn('status', ['Pending', 'Reviewed'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already have an unresolved report against this user.');
        }

        $report = Report::create([
            'reporter_id'       => Auth::id(),
            'reported_user_id'  => $validated['reported_user_id'],
            'conversation_id'   => $validated['conversation_id'] ?? null,
            'reason'            => $validated['reason'],
            'details'           => $validated['details'] ?? null,
            'status'            => 'Pending',
        ]);

        Notification::notify(
            $report->reported_user_id,
            'report_response',
            'You have been reported',
            'Please review the report and provide your response for CES Admin.',
            route('reports.respond.form', $report)
        );

        return back()->with('success', 'Report submitted. CES Admin will review it shortly.');
    }

    public function respondForm(Report $report)
    {
        abort_unless($report->reported_user_id === Auth::id(), 403);
        abort_unless(in_array($report->status, ['Pending', 'Reviewed'], true), 404);

        return view('reports.respond', compact('report'));
    }

    public function respond(Request $request, Report $report)
    {
        abort_unless($report->reported_user_id === Auth::id(), 403);
        abort_unless(in_array($report->status, ['Pending', 'Reviewed'], true), 404);

        $validated = $request->validate([
            'reported_user_response' => 'required|string|max:2000',
        ]);

        $report->update([
            'reported_user_response' => $validated['reported_user_response'],
            'status' => 'Reviewed',
        ]);

        Notification::notify(
            $report->reporter_id,
            'report_response',
            'Response received for your report',
            'The reported user has submitted a response for CES Admin to review.',
            route('chat.index')
        );

        return redirect()->route('chat.index')->with('success', 'Your response has been sent to CES Admin.');
    }
}
